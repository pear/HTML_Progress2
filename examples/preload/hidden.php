<?php
/**
 * Simple example that hide a progress meter at end of process.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2.php';

/**
 *  User process while the progress bar is visible.
 *
 *  @param int     $pValue   current value of the progress bar
 *  @param object  $pBar     the progress bar itself
 */
function myFunctionHandler($pValue, &$pBar)
{
    // nothing to do here, except sleep a bit ... it's only a demo!
    $pBar->sleep();
}

$pb = new HTML_Progress2();
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
$pb->setProgressAttributes(array(
    'position' => 'absolute',
    'auto-size' => false,
    'width' => 220,
    'height' => 24
));
$pb->setLabelAttributes('pct1', array(
    'width' => 0,
    'left' => 190
));
$pb->setProgressHandler('myFunctionHandler');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Hidden preload Progress2 example</title>
<style type="text/css">
<!--
body {
    background-color: #CCCC99;
    color: #996;
    font-family: Verdana, Arial;
}

<?php echo $pb->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $pb->getScript(); ?>
//-->
</script>
</head>
<body>

<?php
$pb->display();
$pb->run();
$pb->hide();
?>

<h1>Your job is finished ! </h1>
<p>The progress meter is now hidden.</p>

</body>
</html>