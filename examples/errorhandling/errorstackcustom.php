<?php
/**
 * Customize error renderer with PEAR_ErrorStack.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/errorhandling/errorstackcustom.php
 *             errorstackcustom source code
 */
require_once 'HTML/Progress2.php';
require_once 'HTML/Progress2/Error.php';
require_once 'PEAR/ErrorStack.php';

/**
 * @ignore
 */
class HTML_Progress2_ErrorStack
{
    function HTML_Progress2_ErrorStack()
    {
        $s = &PEAR_ErrorStack::singleton('HTML_Progress2');
        $t = HTML_Progress2_Error::_getErrorMessage();
        $s->setErrorMessageTemplate($t);
        $s->setContextCallback(array(&$this,'getBacktrace'));
        $logger = array(&$this,'log');
        $s->setLogger($logger);
        $s->pushCallback(array(&$this,'errorHandler'));
    }

    function push($code, $level, $params)
    {
        $s = &PEAR_ErrorStack::singleton('HTML_Progress2');
        return $s->push($code, $level, $params);
    }

    function getBacktrace()
    {
        if (function_exists('debug_backtrace')) {
            $backtrace = debug_backtrace();
            $backtrace = $backtrace[count($backtrace)-1];
        } else {
            $backtrace = false;
        }
        return $backtrace;
    }

    function log($err)
    {
        global $prefs;

        $lineFormat = '<b>%1$s:</b> %2$s<br/>[%3$s]<hr/>'."<br/>\n";
        $contextFormat = 'in <b>%1$s</b> on line <b>%2$s</b>';

        if (isset($prefs['handler']['display']['lineFormat'])) {
            $lineFormat = $prefs['handler']['display']['lineFormat'];
        }
        if (isset($prefs['handler']['display']['contextFormat'])) {
            $contextFormat = $prefs['handler']['display']['contextFormat'];
        }

        $context = $err['context'];

        if ($context) {
            $file  = $context['file'];
            $line  = $context['line'];

            $contextExec = sprintf($contextFormat, $file, $line);
        } else {
            $contextExec = '';
        }

        printf($lineFormat,
               ucfirst(get_class($this)) . ' ' . $err['level'],
               $err['message'],
               $contextExec);
    }

    function errorHandler($err)
    {
        global $halt_onException;

        if ($halt_onException) {
            if ($err['level'] == 'exception') {
                return PEAR_ERRORSTACK_DIE;
            }
        }
    }
}

// set it to on if you want to halt script on any exception
$halt_onException = false;


// Example A. ---------------------------------------------

$stack =& new HTML_Progress2_ErrorStack();

$prefs = array('error_handler' => array(&$stack, 'push'));

// A1. Exception
$pb1 = new HTML_Progress2($prefs, HTML_PROGRESS2_BAR_VERTICAL, '0', 130);


// Example B. ---------------------------------------------

$displayConfig = array(
    'lineFormat' => '<b>%1$s</b>: %2$s<br/>%3$s<hr/>',
    'contextFormat' =>   '<b>File:</b> %1$s <br/>'
                       . '<b>Line:</b> %2$s '
);
$prefs = array(
    'error_handler' => array(&$stack, 'push'),
    'handler' => array('display' => $displayConfig)
);

$pb2 = new HTML_Progress2($prefs);

// B1. Error
$pb2->setMinimum(-1);

// B2. Exception
$pb2->setIndeterminate('true');

print 'still alive !';

?>