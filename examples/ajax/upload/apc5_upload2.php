<?php
/**
 * Custom example of AJAX file upload with HTML_Progress2, PHP 5.2+ and APC
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/ajax/upload/apc5_upload2.php
 *             AP5 basic upload source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/apc5_upload2.png
 *             screenshot (Image PNG, 590x153 pixels) 8,41 Kb
 */

require_once 'PEAR.php';
require_once 'HTML/Progress2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

// build a progress bar without default percentage label
$pb = new HTML_Progress2(null, HTML_PROGRESS2_BAR_HORIZONTAL, 0, 100, false);
$pb->setIdent('PB1');

// will replace the default uplStatus label with formatted option (see auto_server.php)
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'sizeStatus');
// will replace the default percentage label with formatted option (see auto_server.php)
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'percentStatus');

$pb->setCellCount(15);

$pb->setBorderPainted(true);
$pb->setProgressAttributes(array(
    'background-color' => 'transparent',
    'background-image' => 'degrade.jpg',
    'background-repeat' => 'repeat-y'
));
$pb->setCellAttributes(array(
    'active-color' => 'transparent',
    'inactive-color' => 'transparent',
    'height' => 40,
    'width' => 35,
    'background-image' => 'pave-blanc-24.png',
    'background-position' => 'center center',
));
$pb->setBorderAttributes(array(
    'width' => 2,
    'style' => 'solid',
    'color' => 'red'
));
$pb->setLabelAttributes('percentStatus', 'valign=top align=right width=550');

$pb->registerAJAX('auto_server.php', array('RequestAPC5Status'));

// upload progress identifier : must be unique to avoid collision
$progress_key = md5(uniqid(rand(), true));
?>
<html>
<head>
<title>APC PHP5 AJAX Upload Progress Meter custom example </title>
<script type="text/javascript" src="HTML_Progress2.js"></script>
<?php echo $pb->setupAJAX(); ?>
<script type="text/javascript">
//<![CDATA[
HTML_Progress2.serverClassName  = 'RequestAPC5Status';
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
  <input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<?php echo $progress_key; ?>">
  <input type="file" id="userfile"  name="userfile">
  <input type="submit" value="Upload!">
</form>
<iframe id="tfrm" name="tfrm" style="width:1px;height:1px;border:0"></iframe>

<?php $pb->display(); ?>

</body>
</html>