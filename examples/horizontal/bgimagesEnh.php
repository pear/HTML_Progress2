<?php
/**
 * Horizontal ProgressBar filled with cell and background images.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/horizontal/bgimagesEnh.php
 *             bgimages enhance source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/bgimagesenh.png
 *             screenshot (Image PNG, 474x69 pixels) 5.80 Kb
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setAnimSpeed(50);
$pb->setBorderPainted(true);
$pb->setProgressAttributes(array(
    'background-color' => 'transparent',
    'background-image' => 'degrade.jpg',
    'background-repeat' => 'repeat-y'
));
$pb->setCellAttributes(array(
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
$pb->setLabelAttributes('pct1', 'font-size=24 width=80');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Background Images Enhance Progress2 example</title>
<?php
echo $pb->getStyle(false);
echo $pb->getScript(false);
?>
</head>
<body>

<?php
$pb->display();
$pb->run();
?>

</body>
</html>