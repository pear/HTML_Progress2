<?php
/**
 * Observer pattern for progress meter.
 * Uses a custom observer to simulate mail send.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/observer/observer3.php
 *             observer3 source code
 */

require_once 'HTML/Progress2.php';

/**
 * @ignore
 */
class myClass
{
    function doSomething()
    {
       $usecs = 1000 * 1000;  // wait 1 seconde
       $dispatch =& Event_Dispatcher::getInstance('ProgressMeter');

       // A long task to do ... for example sending 10 mails
       for ($i = 0; $i < 10; ++$i) {

           // simulate by a sleep 1 sec function
           if ((substr(PHP_OS, 0, 3) == 'WIN') && (substr(PHP_VERSION,0,1) < '5') ){
               for ($w = 0; $w < $usecs; $w++) { }
           } else {
               usleep($usecs);
           } //

           $dispatch->post($this, 'onTick', array($i));
       }
    }
}

/**
 * @ignore
 */
class myBar extends HTML_Progress2
{
    function myBar()
    {
        parent::HTML_Progress2();
        $this->setIncrement(10);

        $this->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'txt1');
        $this->setLabelAttributes('txt1', array(
            'valign' => 'top',
            'left' => 0,
            ));
    }

    function notify(&$notification)
    {
        $notifyName = $notification->getNotificationName();

        if (strcasecmp($notifyName, 'onTick') == 0) {
            $notifyInfo = $notification->getNotificationInfo();

            if ($notifyInfo[0] == 0) {
                $this->setLabelAttributes('txt1', array('value' => 'Sending mail ...'));

            } elseif ($notifyInfo[0] == 9) {
                $this->setLabelAttributes('txt1', array('value' => 'Mail sent with success.'));
            }
            $this->moveNext();
        }
    }

}

$bar = new myBar();
$bar->addListener(array(&$bar, 'notify'), 'onTick');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Req 7800</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
    background-color: #FFFFFF;
}
 -->
</style>
<?php echo $bar->getScript(false); ?>
</head>
<body>

<?php
$bar->display();

$process = new myClass();
$process->doSomething();
?>

</body>
</html>