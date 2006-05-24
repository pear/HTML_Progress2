<?php
/**
 * Basic Horizontal ProgressBar (using relative position)
 * with multiple labels (crossbar, button, step, text).
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/label/mixed.php
 *             mixed source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/mixed.png
 *             screenshot (Image PNG, 719x255 pixels) 4.93 Kb
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setAnimSpeed(300);
$pb->setIncrement(10);

// Adds additional labels
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'txt1', 'Fire at will');

$pb->addLabel(HTML_PROGRESS2_LABEL_CROSSBAR, 'crs1');
$pb->setLabelAttributes('crs1', array(
    'valign' => 'top',
    'align'  => 'center',
    'width'  => 170,
    'color'  => 'blue'
));

$pb->addLabel(HTML_PROGRESS2_LABEL_STEP, 'stp1');
$pb->setLabelAttributes('stp1', array(
    'valign' => 'bottom',
    'color'  => 'blue'
));

$pb->addLabel(HTML_PROGRESS2_LABEL_BUTTON, 'btn1', 'Run again');
$pb->setLabelAttributes('btn1', array(
    'width' => 100,
    'top' => 0,
    'color' => 'red'
));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Labels Progress2 example</title>
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

<?php
$pb->display();
$pb->run();
?>

</body>
</html>