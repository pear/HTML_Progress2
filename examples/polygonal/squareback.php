<?php
/**
 * Reverse Square progress meter.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/polygonal/squareback.php
 *             squareback source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/squareback.png
 *             screenshot (Image PNG, 94x57 pixels) 473 bytes
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
$pb->setFillWay('reverse');
$pb->setOrientation(HTML_PROGRESS2_POLYGONAL);
$pb->setCellAttributes('width=10 height=10');
$pb->setLabelAttributes('pct1', 'valign=left align=center top=15');
$pb->setCellCoordinates(4,4);     // square 4x4
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>SquareBack Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #FFFFFF;
}
// -->
</style>
<?php echo $pb->getScript(false); ?>
</head>
<body>

<?php
$pb->display();
$pb->run();
?>

</body>
</html>