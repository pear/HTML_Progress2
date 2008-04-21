<?php
/**
 * Custom example of AJAX file upload with HTML_Progress2,
 * PHP 5.2+ and uploadProgress extension
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/ajax/upload/upm5_upload.php
 *             AP5 basic upload source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/upm5_upload.png
 *             screenshot (Image PNG, 470x130 pixels) 4,29 Kb
 */

require_once 'PEAR.php';
require_once 'HTML/Progress2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

// build a default horizontal progress bar
$pb = new HTML_Progress2();
$pb->setIdent('PB1');

// will replace the default uplStatus label with formatted option (see auto_server.php)
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'percentStatus');
// will show the current filename during upload
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'fileName');

$pb->setCellCount(20);

$pb->setLabelAttributes('pct1', array(
    'width' => 440,
    'height' => 20,
    'valign' => 'center',
    'align' => 'center',
    'color' => 'navy'
));
$pb->setBorderPainted(true);
$pb->setCellAttributes(array(
    'active-color' => 'white',
    'inactive-color' => 'lightblue',
    'width' => 20,
    'spacing' => 2
));
$pb->setBorderAttributes(array(
    'width' => 1,
    'style' => 'solid',
    'color' => 'black'
));
$pb->setLabelAttributes('percentStatus', 'valign=top align=left');
$pb->setLabelAttributes('fileName', 'valign=bottom align=left');

$pb->registerAJAX('auto_server.php', array('RequestUPM5Status'));

// upload progress identifier : must be unique to avoid collision
$progress_key = md5(uniqid(rand(), true));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>UPM PHP5 AJAX Upload Progress Meter custom example </title>
<script type="text/javascript" src="HTML_Progress2.js"></script>
<?php echo $pb->setupAJAX(); ?>
<script type="text/javascript">
//<![CDATA[
HTML_Progress2.serverClassName  = 'RequestUPM5Status';
HTML_Progress2.serverMethodName = 'getStatus';
HTML_Progress2.onComplete       = 'doNothing';

function beginUpload()
{
    HTML_Progress2.requestArgs = 'uploadID=<?php echo $progress_key; ?>';
    HTML_Progress2.start('<?php echo $pb->getIdent(); ?>', 1000);

}
function doNothing()
{
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

<form enctype="multipart/form-data" target="tfrm" action="http_upload.php" method="post" onsubmit="beginUpload();">
  <input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<?php echo $progress_key; ?>" />
  <input type="hidden" name="UPLOAD_IDENTIFIER"   id="progress_key" value="<?php echo $progress_key; ?>" />
  <input type="file" id="userfile"  name="userfile" />
  <input type="submit" value="Upload!" />
</form>
<iframe id="tfrm" name="tfrm" style="width:1px;height:1px;border:0"></iframe>

<?php $pb->display(); ?>

</body>
</html>