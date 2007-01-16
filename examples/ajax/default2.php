<?php
/**
 * Reverse horizontal AJAX ProgressBar with red skin, using default Ajax driver.
 * This example show how to use two separate scripts to build progress bar,
 * and handle server side task operations.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/ajax/default2.php
 *             AJAX bgimages source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/bgimages.png
 *             screenshot (Image PNG, 310x40 pixels) 501 bytes
 */

require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setIdent('PB1');
$pb->setIncrement(10);
$pb->setCellAttributes(array(
    'active-color' => '#000084',
    'inactive-color' => '#3A6EA5',
    'width' => 25,
    'spacing' => 0,
    'background-image' => 'download.gif'
));
$pb->setBorderPainted(true);
$pb->setBorderAttributes('width=1 style=inset color=white');
$pb->setLabelAttributes('pct1', array(
    'width' => 60,
    'font-size' => 10,
    'align' => 'center',
    'valign' => 'left'
));

$ae = $pb->registerAjax();
$ae->setRequestUri('default2task.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>BgImages Ajax Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {background-color: #C3C6C3; }
 -->
</style>
<?php echo $pb->getScript(false); ?>
<script type="text/javascript" src="Poly9UrlParser.js"></script>
<script type="text/javascript">
//<![CDATA[
<?php echo $ae->getScript(true); ?>
function complete()
{
   hideProgress(progressId);
}
//]]>
</script>
</head>
<body>

<?php
$pb->display();
?>
<script type="text/javascript">
//<![CDATA[
<?php
$m = $ae->getRequestMethod();
if ($m != 'GET') {
    echo "reqMethod = '$m';\n";
}
$t = $ae->getRequestTimeout();
if ($t != 2000) {
    echo "timeout = '$t';\n";
}
echo "url1 = '". $ae->getRequestUri(1) ."';\n";
echo "url2 = '". $ae->getRequestUri(2) ."';\n";
?>
startTask();
//]]>
</script>

</body>
</html>