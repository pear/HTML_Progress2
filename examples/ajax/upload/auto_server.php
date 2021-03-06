<?php
/**
 * Auto server that will serve upload file informations
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

require_once 'HTML/AJAX/Server.php';

class AutoServer extends HTML_AJAX_Server
{
    // this flag must be set for your init methods to be used
    var $initMethods = true;

    function initAPC5UploadStatus()
    {
        require_once 'HTML/Progress2/Upload.php';
        $status = new HTML_Progress2_Upload();
        $this->registerClass($status, 'APC5UploadStatus', array('getStatus'));
    }

    function initRequestAPC5Status()
    {
        require_once 'MyUploadProgressMeterStatus.class.php';
        $format = array('sizeStatus' => '%C (%T)', 'percentStatus' => 'Uploading: please wait ... %P% done');
        $status = new MyUploadProgressMeterStatus($format);
        $this->registerClass($status, 'RequestAPC5Status', array('getStatus'));
    }

    function initRequest1APC5Status()
    {
        require_once 'MyUploadProgressMeterStatus.class.php';
        $format = array('sizeStatus' => 'Uploaded: %C of %T',
                        'pct1' => '%P%',
                        'fileName' => 'Current file: %F');
        $status = new MyUploadProgressMeterStatus($format);
        $this->registerClass($status, 'Request1APC5Status', array('getStatus'));
    }

    function initRequestUPM5Status()
    {
        require_once 'MyUploadProgressMeterStatus.class.php';
        $format = array('pct1' => '%P%',
                        'percentStatus' => '%E left (at %S/sec)  %C/%T(%P%)',
                        'fileName' => 'Current file: %F');
        $status = new MyUploadProgressMeterStatus($format);
        $this->registerClass($status, 'RequestUPM5Status', array('getStatus'));
    }
}

$server = new AutoServer();
$server->handleRequest();
?>