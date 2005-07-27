<?php
/**
 * Horizontal ProgressBar filled with background image.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setAnimSpeed(200);
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Background Images Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #C3C6C3;
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