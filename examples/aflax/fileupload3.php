<?php
/**
 * AFLAX file upload example with modified behaviors.
 *
 * Progress meter has 3 buttons (btn1: select File, btn2: begin Upload, btn3: cancel Upload)
 * and a status text label (aflaxstatus)
 * We use HTML_Progress2::setFrameAttributes() to give an applet look like.
 * We use these AFLAX settings :
 * - Adobe Flash is "aflax.swf" in current directory,
 * - JavaScript backend "ajax.js" and "HTML_Progress2_AFLAX.js" are also in current directory
 * - Files allowed to upload are :
 *   Images (*.jpg, *.jpeg, *.gif, *.png) and Movies (*.mpg, *.mov)
 * - The server script named "http_upload.php" to handle files uploaded reside in current directory
 *   and used PEAR::HTTP_Upload package facility
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setIdent('PB1');

$pb->setCellAttributes(array(
    'active-color' => '#000084',
    'inactive-color' => '#3A6EA5',
    'width' => 25
));
$pb->setLabelAttributes('pct1', array(
    'width' => 60,
    'font-size' => 10,
    'align' => 'center',
    'valign' => 'right'
));

$pb->setFrameAttributes(array('width' => 600,
    'color' => 'lightblue', 'border-width' => 1, 'border-color' => 'black')
    );

// aflax status label is optional : try to remove it and your are
// no feedback as in fileupload1.php example but no js errors/warnings.
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'aflaxstatus');
$pb->setLabelAttributes('aflaxstatus', array(
    'valign' => 'bottom'
    ));

$pb->addLabel(HTML_PROGRESS2_LABEL_BUTTON, 'btn1', 'Select File');
$pb->setLabelAttributes('btn1', array(
    'valign' => 'right',
    'width'  => 80,
    'top'    => 2,
    'left'   => 60,
    'action' => 'javascript:HTML_Progress2_AFLAX_selectFile();'
    ));

$pb->addLabel(HTML_PROGRESS2_LABEL_BUTTON, 'btn2', 'Upload');
$pb->setLabelAttributes('btn2', array(
    'valign' => 'right',
    'width'  => 80,
    'top'    => 2,
    'left'   => 145,
    'action' => 'javascript:HTML_Progress2_AFLAX_beginUpload();'
    ));

$pb->addLabel(HTML_PROGRESS2_LABEL_BUTTON, 'btn3', 'Cancel');
$pb->setLabelAttributes('btn3', array(
    'valign' => 'right',
    'width'  => 80,
    'top'    => 2,
    'left'   => 230,
    'action' => 'javascript:HTML_Progress2_AFLAX_cancelUpload();'
    ));

$pb->registerAFLAX('aflax.swf',
    'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/http_upload.php'
    );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AFLAX file upload example 3 </title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

.progressButtonLabelbtn1PB1, .progressButtonLabelbtn2PB1, .progressButtonLabelbtn3PB1 {
    color: navy;
}
.progressButtonLabelbtn1PB1:disabled, .progressButtonLabelbtn2PB1:disabled, .progressButtonLabelbtn3PB1:disabled {
    color: white;
}
body {background: #eeeeee;}
 -->
</style>
<script type="text/javascript" src="./HTML_Progress2.js"></script>
<?php
echo $pb->setupAFLAX(false, '.');
?>
</head>
<body>

<h1>This demo shows asynchronous file uploading using AFLAX.</h1>

<script type="text/javascript">
//<![CDATA[
aflax.insertFlash(0, 0, '#FFFFFF', 'HTML_Progress2_AFLAX_setupBrowse');
//]]>
</script>

<?php $pb->display(); ?>

</body>
</html>