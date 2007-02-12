<?php
/**
 * Basic example of AJAX file upload with HTML_Progress2, PHP 5.2+ and APC
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/ajax/upload/apc5_upload1.php
 *             AP5 basic upload source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/apc5_upload1.png
 *             screenshot (Image PNG, 315x127 pixels) 2,84 Kb
 */

// final destination of uploaded files
$path = 'web_files/' ;

// basic PHP function file upload handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $path . $_FILES['userfile']['name'])) {
            $html_output = 'Upload finished';
            echo '<pre>'; var_dump($_FILES); echo '</pre>';
        } else {
            $html_output = 'Upload failed';
        }
    }
    die($html_output);
}

require_once 'HTML/Progress2.php';

// build a very basic progress bar with default size and colors
$pb = new HTML_Progress2();
$pb->setIdent('PB1');

// add default text label area to get current upload info
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'uplStatus');

$pb->registerAJAX('auto_server.php', array('APC5UploadStatus'));

// upload progress identifier : must be unique to avoid collision
$progress_key = uniqid();
?>
<html>
<head>
<title>APC PHP5 AJAX Upload Progress Meter basic example </title>
<script type="text/javascript" src="HTML_Progress2.js"></script>
<?php echo $pb->setupAJAX(); ?>
<script type="text/javascript">
//<![CDATA[
HTML_Progress2.serverClassName  = 'APC5UploadStatus';
HTML_Progress2.serverMethodName = 'getStatus';
HTML_Progress2.requestArgs      = 'upload_identifier=<?php echo $progress_key; ?>';
HTML_Progress2.onComplete       = 'doUserAlert';

function doUserAlert()
{
    alert('Upload file done !');
}
//]]>
</script>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {background-color: #EEEEEE; }
 -->
</style>
</head>
<body>

<form enctype="multipart/form-data" target="tfrm" action="apc5_upload1.php" method="post" onsubmit="HTML_Progress2.start('<?php echo $pb->getIdent(); ?>', 500);">
  <input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<?php echo $progress_key; ?>">
  <input type="file" id="userfile"  name="userfile">
  <input type="submit" value="Upload!">
</form>
<iframe id="tfrm" name="tfrm" style="width:1px;height:1px;border:0"></iframe>

<?php $pb->display(); ?>

</body>
</html>