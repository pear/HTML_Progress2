<?php
/**
 * Horizontal progress bar without string (text info).
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2(null, HTML_PROGRESS2_BAR_HORIZONTAL, 0, 100, false);
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>NoString Progress2 example</title>
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