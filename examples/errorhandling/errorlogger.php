<?php
/**
 * Customize error renderer with default PEAR_Error object
 * and PEAR::Log (db handler, mysql driver).
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/errorhandling/errorlogger.php
 *             errorlogger source code
 */
require_once 'HTML/Progress2.php';
require_once 'PEAR.php';
require_once 'Log.php';

function myErrorCallback($pb_error)
{
    $display_errors = ini_get('display_errors');
    $log_errors = ini_get('log_errors');

    if ($display_errors) {
        printf('<b>HTML_Progress2 error :</b> %s<br/>', $pb_error->getMessage());
    }

    if ($log_errors) {
        $userinfo = $pb_error->getUserInfo();

        $lineFormat = '%1$s %2$s';
        $contextFormat = '(Function="%3$s" File="%1$s" Line="%2$s")';

        $options =& $userinfo['log']['sql'];
        $db_table =& $options['name'];
        $ident =& $options['ident'];
        $conf =& $options['conf'];

        if (isset($conf['lineFormat'])) {
            $lineFormat = $conf['lineFormat'];
        }
        if (isset($conf['contextFormat'])) {
            $contextFormat = $conf['contextFormat'];
        }

        $logger = &Log::singleton('sql', $db_table, $ident, $conf);

        $msg = $pb_error->getMessage();
        $ctx = $pb_error->sprintContextExec($contextFormat);
        $message = sprintf($lineFormat, $msg, $ctx);

        switch ($userinfo['level']) {
         case 'exception':
             $logger->alert($message);
             break;
         case 'error':
             $logger->err($message);
             break;
         case 'warning':
             $logger->warning($message);
             break;
         default:
             $logger->notice($message);
        }
    }
}

function myErrorHandler()
{
    // always returns error; do not halt script on exception
    return null;
}

ini_set('display_errors',1);
ini_set('log_errors',1);


// Example A. ---------------------------------------------

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'myErrorCallback');


$dbms     = 'mysql';     // your database management system
$db_user  = 'root';      // your database user account
$db_pass  = '****';      // your database user-password account
$db_name  = 'test';      // your database name
$db_table = 'log_table'; // your database log table

/**
 * CREATE TABLE log_table (
 *  id          INT NOT NULL,
 *  logtime     TIMESTAMP NOT NULL,
 *  ident       CHAR(16) NOT NULL,
 *  priority    INT NOT NULL,
 *  message     VARCHAR(255),
 *  PRIMARY KEY (id)
 * );
 */

$options = array(
    'dsn' => "$dbms://$db_user:$db_pass@/$db_name",
    'contextFormat' => '[File="%1$s" Line="%2$s"]'
);
$sql_handler = array('name' => $db_table,
                     'ident' => 'HTML_Progress2',
                     'conf' => $options
                     );
$logConfig = array('sql' => $sql_handler);

$prefs = array(
    'push_callback' => 'myErrorHandler',
    'handler' => array('log' => $logConfig)
);

// A1. Exception
$pb1 = new HTML_Progress2($prefs, HTML_PROGRESS2_BAR_VERTICAL, '0', 130);

// A2. Error
$pb1->setMinimum(-1);

// A3. Exception
$pb1->setIndeterminate('true');

if ($pb1->hasErrors()) {
    $msg  = "<br /><hr />";
    $msg .= "Previous errors has been recorded in database '$db_name',";
    $msg .= " table '$db_table'";
    echo "$msg <br /><br />";
}

print 'still alive !';

?>