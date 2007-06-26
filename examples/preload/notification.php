<?php
/**
 * Simple example that hide a progress meter at end of long preload work process
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/preload/notification.php
 *             notification source code
 */

require_once 'HTML/Progress2.php';

// Will be defined on core of version 2.4.0 or better
if (!defined('HTML_PROGRESS2_NOTIFICATION_DISPATCHER')) {
    define('HTML_PROGRESS2_NOTIFICATION_DISPATCHER', 'ProgressMeter');
}

class myClass
{
    function doSomething()
    {
       $dispatch =& Event_Dispatcher::getInstance(HTML_PROGRESS2_NOTIFICATION_DISPATCHER);

       // put here all your preload work, such as database queries, webservice queries, ...
       // you may use other notification name than 'onTick' (just an example)
       // but WARNING, avoid to use reserved progress2 meter notification names.
       for ($i = 0; $i < 10; ++$i) {
           $dispatch->post($this, 'onTick', array($i));
       } //
    }
}

class myBar extends HTML_Progress2
{
    function myBar()
    {
        parent::HTML_Progress2();
    }

    function notify(&$notification)
    {
        $this->process();   // just for demo (sleep a bit : 0.5sec for each notification)
                            // NOT necessary in real condition
        $this->moveNext();
    }

}

$bar = new myBar();
$bar->setAnimSpeed(500);
$bar->setIncrement(10);
$bar->addListener(array(&$bar, 'notify'), 'onTick');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Observer Progress2 example</title>
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
$bar->hide();
?>

<h1>Your job is finished ! </h1>
<p>The progress meter is now hidden.</p>

</body>
</html>