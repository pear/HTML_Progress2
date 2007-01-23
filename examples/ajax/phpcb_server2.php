<?php
/**
 * Simple server with PHP callback function, that will serve user task script responder
 * and used scriptaculous effects libraries
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
session_start();

function getPercentage()
{
    $newVal = $_SESSION['progressPercentage'] + mt_rand(1, 25);
    $_SESSION['progressPercentage'] = min(100, $newVal);

    // should return at least an array with one key ('percentage') and its value
    $status = array('percentage' => $_SESSION['progressPercentage']);
    return $status;
}

require_once 'HTML/AJAX/Server.php';

// register normal function
$callback = 'getPercentage';

$server = new HTML_AJAX_Server();
$server->registerPhpCallback($callback);
$server->registerJsLibrary('scriptaculous',
    array('prototype.js', 'scriptaculous.js', 'effects.js'),
    dirname(__FILE__) . DIRECTORY_SEPARATOR. 'scriptaculous-js-1.7.0' . DIRECTORY_SEPARATOR);
$server->handleRequest();
?>