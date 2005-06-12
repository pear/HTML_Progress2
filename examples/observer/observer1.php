<?php
/**
 * Default observer pattern for progress meter.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2.php';
require_once 'HTML/Progress2/Observer.php';

// 1. Creates progress meter
$pb = new HTML_Progress2();
$pb->setComment('Default Observer Progress2 example');
$pb->setAnimSpeed(200);
$pb->setIncrement(10);

// 2. Creates and attach a listener
$observer = new HTML_Progress2_Observer();

$ok = $pb->addListener($observer);
if (!$ok) {
    die ("Cannot add a valid listener to progress meter !");
}

// 3. Changes look-and-feel of progress meter
//    ( border: 2px, solid, #000000 )
$pb->setBorderPainted(true);
$pb->setBorderAttributes('width=2');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Default Observer Progress2 example</title>
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