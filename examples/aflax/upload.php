<?php
/**
 * Basic AFLAX file upload example that used standard PHP functions
 * to handle uploaded files.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @link       http://www.php.net/manual/en/features.file-upload.php
 *             Handling file uploads
 */

$dest_dir = 'web_files/';

$html_output = 'No file uploaded !';

if (is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
    if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $dest_dir . $_FILES['Filedata']['name'])) {
        $html_output = 'Upload finished';
    } else {
        $html_output = 'Upload failed';
    }
}

echo "<html><head></head><body><script type='text/javascript'>document.write('".
    addslashes($html_output). "');</script></body></html>";
flush();
?>