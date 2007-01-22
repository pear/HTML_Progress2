<?php
/**
 * A simple server that will serve user task script responder
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

session_start();

require_once 'RequestStatus.class.php';
require_once 'HTML/AJAX/Server.php';

$status = new RequestStatus();

$server = new HTML_AJAX_Server();
$server->registerClass($status, 'RequestStatus', array('updatePercentage'));
$server->handleRequest();
?>