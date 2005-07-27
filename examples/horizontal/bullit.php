<?php
/**
 * Horizontal plain progress bar.
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
    'width' => 20,
    'spacing' => 0
));
$pb->setBorderPainted(true);
$pb->setBorderAttributes('width=1 style=inset color=white');
$pb->setLabelAttributes('pct1', array(
    'width' => 198,
    'height' => 24,
    'font-size' => 14,
    'valign' => 'top',
    'align' => 'right'
));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Bullit Progress2 example</title>
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