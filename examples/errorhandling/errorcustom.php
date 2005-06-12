<?php
/**
 * Customize error renderer with default PEAR_Error object.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2.php';
require_once 'PEAR.php';

function dump($title, $e)
{
    echo "<h1> $title </h1>";
    echo '<pre>';
    var_dump($e);
    echo '</pre>';
    echo '<hr/>';
}

function myErrorCallback($pb_error)
{
    $keys = array('error_message_prefix', 'mode', 'level', 'code', 'message');
    
    foreach ($keys as $i => $k) {
        printf("%s = %s <br/>\n", $k, $pb_error->$k);
    }
    echo '<hr/>';
}

function my1ErrorHandler()
{
    return null;
}

function my2ErrorHandler()
{
    return PEAR_ERROR_CALLBACK;
}

/*
 * be sure that we will print and log error details.
 * @see HTML_Progress2_Error::log()
 */
ini_set('display_errors',1);
ini_set('log_errors',1);


// Example A. ---------------------------------------------

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'myErrorCallback');

$prefs = array('push_callback' => 'my1ErrorHandler');

// A1. Exception
$pb1 = new HTML_Progress2($prefs, HTML_PROGRESS2_BAR_VERTICAL, '0', 130);


// Example B. ---------------------------------------------

$displayConfig = array(
    'lineFormat' => '<b>%1$s</b>: %2$s<br/>%3$s<hr/>',
    'contextFormat' =>   '<b>File:</b> %1$s <br />'
                       . '<b>Line:</b> %2$s <br />'
                       . '<b>Function:</b> %3$s '
);
$prefs = array(
    'push_callback' => 'my2ErrorHandler',
    'handler' => array('display' => $displayConfig)
);

$pb2 = new HTML_Progress2($prefs);

// B1. Error
$pb2->setMinimum(-1);

// B2. Exception
$pb2->setIndeterminate('true');

print 'still alive !';  

?>