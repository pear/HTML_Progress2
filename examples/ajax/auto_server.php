<?php
/**
 * Auto server that will serve user task script responder
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

session_start();

require_once 'HTML/AJAX/Server.php';

class AutoServer extends HTML_AJAX_Server
{
    // this flag must be set for your init methods to be used
    var $initMethods = true;

    function initRequestStatus()
    {
        include_once 'RequestStatus.class.php';
        $status = new RequestStatus();
        $this->registerClass($status, 'RequestStatus', array('updatePercentage'));
    }

    function initRequestFullStatus()
    {
        include_once 'RequestStatus.class.php';
        $status = new RequestStatus();
        $this->registerClass($status, 'RequestFullStatus', array('updateTask'));
    }

    function initRequestStatusAndFx()
    {
        include_once 'RequestStatus.class.php';
        $status = new RequestStatus();
        $this->registerClass($status, 'RequestStatusAndFx', array('updateTask'));

        $this->registerJsLibrary('scriptaculous',
            array('prototype.js', 'scriptaculous.js', 'effects.js'),
            dirname(__FILE__) . DIRECTORY_SEPARATOR. 'scriptaculous-js-1.7.0' . DIRECTORY_SEPARATOR);
    }
}

$server = new AutoServer();
$server->handleRequest();
?>