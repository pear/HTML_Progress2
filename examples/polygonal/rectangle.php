<?php
/**
 * Basic Rectangle progress meter.
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
$pb->setOrientation(HTML_PROGRESS2_POLYGONAL);
$pb->setCellAttributes(array(
    'width'  => 15,
    'height' => 15,
    'active-color'   => 'red',
    'inactive-color' => 'orange',
    )
);
$pb->setLabelAttributes('pct1', 'valign=bottom align=center width=90 left=0');
$pb->setCellCoordinates(6,4);     // Rectangle 6x4
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Rectangle Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #FFFFFF;
}
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $pb->getScript(); ?>
//-->
</script>
</head>
<body>

<?php
$pb->display();
$pb->run();
?>

</body>
</html>