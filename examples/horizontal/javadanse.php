<?php
/**
 * 20 cells Horizontal progress bar
 * filled from right to left with JavaScript customization.
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
$pb->setAnimSpeed(100);
$pb->setIncrement(5);
$pb->setFillWay('reverse');
$pb->setCellCount(20);
$pb->setCellAttributes(array(
    'active-color' => '#970038',
    'inactive-color' => '#FFDDAA',
    'width' => 20,
    'font-size' => 14
));
$pb->setBorderPainted(true);
$pb->setBorderAttributes('width=1');
$pb->setLabelAttributes('pct1', array(
    'width' => 440,
    'font-size' => 14,
    'color' => '#FF0000',
    'align' => 'center',
    'valign' => 'bottom'
));
$pb->setScript('progress2_number.js');

foreach (range(0,2) as $index) {
    $pb->setCellAttributes('color=red', $index);
}
foreach (range(3,6) as $index) {
    $pb->setCellAttributes('color=yellow', $index);
}
foreach (range(7,9) as $index) {
    $pb->setCellAttributes('color=white ', $index);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>JavaDanse Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #FFFFFF;
}
// -->
</style>
<script type="text/javascript" src="<?php echo $pb->getScript(); ?>"></script>
</head>
<body>

<?php
$pb->display();
$pb->run();
?>

</body>
</html>