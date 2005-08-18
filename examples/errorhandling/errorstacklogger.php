<?php
/**
 * Customize error renderer with PEAR_ErrorStack and PEAR::Log.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/errorhandling/errorstacklogger.php
 *             errorstacklogger source code
 */
require_once 'HTML/Progress2.php';
require_once 'HTML/Progress2/Error.php';
require_once 'PEAR/ErrorStack.php';
require_once 'Log.php';

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
        $s->setMessageCallback(array(&$this,'getMessage'));
        $s->setContextCallback(array(&$this,'getBacktrace'));

        $ident = $_SERVER['REMOTE_ADDR'];
        $conf  = array('lineFormat' => '%1$s - %2$s [%3$s] %4$s');
        $file = &Log::singleton('file', 'html_progress2_err.log', $ident, $conf);

        $conf = array('error_prepend' => '<font color="#ff0000"><tt>',
                      'error_append'  => '</tt></font>'
                      );
        $display = &Log::singleton('display', '', '', $conf);

        $composite = &Log::singleton('composite');
        $composite->addChild($display);
        $composite->addChild($file);

        $s->setLogger($composite);
        $s->pushCallback(array(&$this,'errorHandler'));
    }

    function push($code, $level, $params)
    {
        $s = &PEAR_ErrorStack::singleton('HTML_Progress2');
        return $s->push($code, $level, $params);
    }

    /**
     *  default ErrorStack message callback is
     *  PEAR_ErrorStack::getErrorMessage()
     */
    function getMessage(&$stack, $err, $template = false)
    {
        global $prefs;

        $message = $stack->getErrorMessage($stack, $err, $template);

        $lineFormat = '%1$s %2$s [%3$s]';
        $contextFormat = 'in %1$s on line %2$s';

        if (isset($prefs['handler']['display']['lineFormat'])) {
            $lineFormat = $prefs['handler']['display']['lineFormat'];
            $lineFormat = strip_tags($lineFormat);
        }
        if (isset($prefs['handler']['display']['contextFormat'])) {
            $contextFormat = $prefs['handler']['display']['contextFormat'];
            $contextFormat = strip_tags($contextFormat);
        }

        $context = $err['context'];

        if ($context) {
            $file  = $context['file'];
            $line  = $context['line'];

            $contextExec = sprintf($contextFormat, $file, $line);
        } else {
            $contextExec = '';
        }

        $msg = sprintf($lineFormat, '', $message, $contextExec);
        return trim($msg);
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

function dump($title, $e)
{
    echo "<h1> $title </h1>";
    print_r($e['message']);
    echo '<br/>';
}

// set it to on if you want to halt script on any exception
$halt_onException = false;


// Example A. ---------------------------------------------

$stack =& new HTML_Progress2_ErrorStack();

$prefs = array('error_handler' => array(&$stack, 'push'));

// A1. Exception
$pb1 = new HTML_Progress2($prefs, HTML_PROGRESS2_BAR_VERTICAL, '0', 130);


$countErrors = $pb1->hasErrors();
for ($i=0; $i<$countErrors; $i++) {
    $e = $pb1->getError();
    dump('html_progress2_errorstack ('.$i.')', $e);
}


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