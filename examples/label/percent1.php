<?php
/**
 * Basic Horizontal ProgressBar
 * with a simple percent label on right side (using relative position).
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/label/percent1.php
 *             percent1 source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/labelpercent1.png
 *             screenshot (Image PNG, 669x361 pixels) 5.02 Kb
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setAnimSpeed(300);
$pb->setIncrement(10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Percent Label relative Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #E0E0E0;
    color: #000000;
    font-family: Verdana, Arial;
}
 -->
</style>
<?php echo $pb->getScript(false); ?>
</head>
<body>
<p style="background-color:orange;
          width:400px;height:200px;
          text-align:center;">
400x200</p>
<h1>Percent Label using relative position </h1>
<p>Default behaviour.</p>

<?php
$pb->display();
$pb->run();
$pb->hide();
?>

<p>Process Ended !</p>

</body>
</html>