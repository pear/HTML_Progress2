<?php
/**
 * Simply ignores html_progress2 errors that occurs
 * with PEAR_Error handler.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2.php';

function dump($title, $e)
{
    echo "<h2> $title </h2>";
    print_r($e);
    echo '<hr/>';
}

function myErrorHandler()
{
    return null;
}

// Example A. ---------------------------------------------

$prefs = array('error_handler' => 'myErrorHandler');

// A1. Exception
$pb1 = new HTML_Progress2($prefs, HTML_PROGRESS2_BAR_VERTICAL, '0', 130);

// A2. Error
$pb1->setMinimum(-1);

// A3. Exception
$pb1->setIndeterminate('true');


$countErrors = $pb1->hasErrors();
if ($countErrors > 0) {
    echo "<h1>$countErrors errors has occured </h1>";
    for ($i=0; $i<$countErrors; $i++) {
        $e = $pb1->getError();
        dump('error #'.($i+1), $e);
    }
}

print 'still alive !';  

?>