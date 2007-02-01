<?php
/**
 * Basic AFLAX file upload example that used PEAR::HTTP_Upload package facility
 * to handle uploaded files.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

require_once 'PEAR.php';
require_once 'HTTP/Upload.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$upload = new HTTP_Upload();

$file = $upload->getFiles('Filedata');

if ($file->isValid()) {
    $file->setName('safe');
    $dest_dir = 'web_files/';
    $dest_name = $file->moveTo($dest_dir);

} elseif ($file->isError()) {
    echo $file->errorMsg();

} else {
    echo '<pre>';
    var_dump($file->getProp());
    echo '</pre>';
}
?>