<?php
/**
 * Simply ignores html_progress2 errors that occurs
 * with PEAR_ErrorStack handler.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/errorhandling/errorstackignore.php
 *             errorstackignore source code
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

    function errorHandler()
    {
        return PEAR_ERRORSTACK_IGNORE;
    }
}

function dump($title, $e)
{
    echo "<h1> $title </h1>";
    print_r($e['message']);
    echo '<br/>';
}


// Example A. ---------------------------------------------

$stack =& new HTML_Progress2_ErrorStack();

$prefs = array('error_handler' => array(&$stack, 'push'));

// A1. Exception
$pb1 = new HTML_Progress2($prefs, HTML_PROGRESS2_BAR_VERTICAL, '0', 130);


$countErrors = $pb1->hasErrors();
for ($i=0; $i<$countErrors; $i++) {
    $e = $pb1->getError();
    dump('PB1 html_progress2_errorstack ('.$i.')', $e);
}


// Example B. ---------------------------------------------

$pb2 = new HTML_Progress2($prefs);

// B1. Error
$pb2->setMinimum(-1);

// B2. Exception
$pb2->setIndeterminate('true');


$countErrors = $pb2->hasErrors();
for ($i=0; $i<$countErrors; $i++) {
    $e = $pb2->getError();
    dump('PB2 html_progress2_errorstack ('.$i.')', $e);
}

print 'still alive !';

?>