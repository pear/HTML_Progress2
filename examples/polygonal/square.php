<?php
/**
 * Basic squares progress meter started in each corners.
 * A simple rotate function (for-loop) is applied
 * on reference coordinates to give new ones.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/polygonal/square.php
 *             square source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/square.png
 *             screenshot (Image PNG, 76x92 pixels) 462 bytes
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
$pb->setOrientation(HTML_PROGRESS2_POLYGONAL);
$pb->setCellAttributes('width=20 height=20');
$pb->setLabelAttributes('pct1', 'valign=top align=center height=20');
$w = $h = 3;  // square 3x3
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Square Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #FFFFFF;
}
 -->
</style>
<?php echo $pb->getScript(false); ?>
</head>
<body>

<?php
$pb->setCellCoordinates($w,$h);
// reference coordinates (top left corner)
$coord = $pb->getCellCoordinates();

// 1. begin at top left corner (default)
$pb->display();
$pb->run();

// 2. begin at top right corner
$c = $coord;
for ($i=1; $i<$w; $i++) {
    $shift = array_shift($c);
    array_push($c, $shift);
}
$pb->setCellCoordinates($w,$h,$c);
$pb->setValue(0);
$pb->display();
$pb->run();

// 3. begin at bottom right corner
$c = $coord;
for ($i=1; $i<($w+$h-1); $i++) {
    $shift = array_shift($c);
    array_push($c, $shift);
}
$pb->setCellCoordinates($w,$h,$c);
$pb->setValue(0);
$pb->display();
$pb->run();

// 4. begin at bottom left corner
$c = $coord;
for ($i=1; $i<$w; $i++) {
    $pop = array_pop($c);
    array_unshift($c, $pop);
}
$pb->setCellCoordinates($w,$h,$c);
$pb->setValue(0);
$pb->display();
$pb->run();
?>

</body>
</html>