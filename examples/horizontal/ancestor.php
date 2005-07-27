<?php
/**
 * Basic Horizontal ProgressBar version 0.5 style.
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
$pb->setLabelAttributes('pct1', array(
    'width' => 60,
    'height' => 24,
    'top' => 0,
    'left' => 0,
    'background-color' => '#FFFFFF',
    'font-size' => 14,
    'align' => 'center'
    ));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Ancestor Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #444444;
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