<?php
/**
 * A basic observer for progress meter.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/observer/observer1.php
 *             observer1 source code
 */
require_once 'HTML/Progress2.php';

// Observer that record serialized event datas
function myObserver(&$notification)
{
    $notifyName = $notification->getNotificationName();
    $notifyInfo = $notification->getNotificationInfo();

    $info = array_merge(array('event' => $notifyName), $notifyInfo);
    $msg = serialize($info);
    error_log ("$msg \n", 3, 'progress_observer.log');
}

// 1. Creates progress meter
$pb = new HTML_Progress2();
$pb->setComment('Basic Observer Progress2 example');
$pb->setAnimSpeed(200);
$pb->setIncrement(10);

// 2. Attach an observer
$pb->addListener('myObserver');

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