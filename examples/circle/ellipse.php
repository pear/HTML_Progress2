<?php
/**
 * Draw a plain Ellipse progress meter.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/circle/ellipse.php
 *             ellipse source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/ellipse080.png
 *             screenshot (Image PNG, 315x115 pixels) 1.80 Kb
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
$pb->setOrientation(HTML_PROGRESS2_CIRCLE);
$pb->setCellAttributes(array(
    'width' => 200,
    'height' => 100,
    'spacing' => 0,
    'inactive-color' => 'red',
    'active-color' => 'navy'
    )
);
$pb->setLabelAttributes('pct1', 'font-size=20 width=100 top=35');
$fileMask = 'e%s.png';
$cacheDir = 'cache/';

if (!is_dir($cacheDir)) {
    die("Directory <b>$cacheDir</b> does not exists");
}
if (file_exists($cacheDir . 'e0.png')) {
    // uses cached pictures rather than create it again
    foreach (range(0,10) as $index) {
        $file = sprintf($cacheDir . $fileMask, $index);
        $pb->setCellAttributes(array('background-image' => $file), $index);
    }
} else {
    // creates ellipse segments pictures only once
    $pb->drawCircleSegments($cacheDir, $fileMask);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Ellipse Progress2 example</title>
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