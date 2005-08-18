<?php
/**
 * Default Progress2 Monitor. Used default QF renderer.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/monitor/monitordef.php
 *             monitordef source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/monitordef.png
 *             screenshot (Image PNG, 246x115 pixels) 2.22 Kb
 */
require_once 'HTML/Progress2/Monitor.php';

$pm = new HTML_Progress2_Monitor();

$pb =& $pm->getProgressElement();
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Default Progress2 Monitor </title>
<?php
echo $pm->getStyle(false);
echo $pm->getScript(false);
?>
</head>
<body>

<?php
$pm->display();
$pm->run();
?>

</body>
</html>