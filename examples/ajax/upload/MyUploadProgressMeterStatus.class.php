<?php
/**
 * Custom backend example of AJAX file upload with HTML_Progress2, PHP 5.2+ and APC
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

require_once 'HTML/Progress2/Upload.php';

/**
 * This class show how to use a custom upload identifier
 * through the query string (see also apc5_upload2.php, HTML_Progress2.requestArgs)
 * and handle progress bar labels values.
 */
class MyUploadProgressMeterStatus extends HTML_Progress2_Upload
{
    function MyUploadProgressMeterStatus($format = null)
    {
        parent::__construct($format);
    }

    function getStatus($uplId = null)
    {
        if (!isset($uplId)) {
            $uplId = $_GET['uploadID'];
        }
        $tmp = $this->getInfo($uplId);

        $ret = parent::getStatus($uplId);
        if (is_array($ret) && $ret['percentage'] == 100) {
            $ret['labels']['percentStatus'] = 'Upload done !';
        }
        return $ret;
    }
}
?>