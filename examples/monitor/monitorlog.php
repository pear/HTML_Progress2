<?php
/**
 * Progress2 Monitor with default QF renderer
 * and a user listener for logging events.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2/Monitor.php';

function getmicrotime($time)
{
    list($usec, $sec) = explode(' ', $time);
    return ((float)$usec + (float)$sec);

}

function logger(&$notification)
{
    static $time_start;
    global $pm;

    $notifyName = $notification->getNotificationName();
    $notifyInfo = $notification->getNotificationInfo();

    if ($notifyName == 'onSubmit') {
        $time_start = getmicrotime($notifyInfo['time']);

    } elseif ($notifyName == 'onLoad') {
        $elapse = getmicrotime($notifyInfo['time']) - $time_start;
        printf('script runtime: %f seconds.', $elapse);

    } elseif ($notifyName == 'onChange') {

        if (fmod($notifyInfo['value'], 25) == 0) {
            $time = getmicrotime($notifyInfo['time']);

            $elapse = $time - $time_start;
            $pm->setCaption('%value%% has been reached on %time% sec.',
                array('value' => $notifyInfo['value'], 'time' => sprintf('%01.3f',$elapse))
            );
        }
    }
}


$pm = new HTML_Progress2_Monitor();

$pb =& $pm->getProgressElement();
$pb->setAnimSpeed(100);
$pb->addListener('logger');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Logger Progress2 Monitor </title>
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