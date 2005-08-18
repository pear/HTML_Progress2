<?php
/**
 * Mailer no timeout pattern with HTML_Progress2_Lite.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/lite/mailer2.php
 *             mailer2 source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/mailer2.png
 *             screenshot (Image PNG, 425x314 pixels) 3.57 Kb
 */

require_once 'HTML/Progress2_Lite.php';

/**
 * NOTE: The function {@link http://www.php.net/manual/en/function.usleep.php}
 *       did not work on Windows systems until PHP 5.0.0
 */
 function _sleep($usecs)
{
    if ((substr(PHP_OS, 0, 3) == 'WIN') && (substr(PHP_VERSION,0,1) < '5') ){
        for ($i=0; $i<$usecs; $i++) { }
    } else {
        usleep($usecs);
    }
}

$pb = new HTML_Progress2_Lite(array(
    'left' => 150,
    'top' => 240,
    'width' => 400,
    'height' => 50,
    'padding' => 2
));
$pb->setBarAttributes(array(
    'color' => '#FF6633',
    'background-color' => 'yellow'
));
$pb->addLabel('percent', 'pct1');
$pb->setLabelAttributes('pct1', array(
    'width' => 0,
    'left' => 570,
    'top' => 250,
    'font-size' => 24,
    'font-weight' => 'normal',
    'color' => 'navy',
    ));

// Adds additional text label for process legend
$labelTxtID = 'legend';
$pb->addLabel('text', $labelTxtID);
$pb->setLabelAttributes($labelTxtID, array(
    'color' => 'navy',
    'font-size' => 14,
    'font-weight' => 'bold',
    'top' => 220
    ));

$maximum_send = 5;           // max number of emails to send each page load
$total_subscribers = 500;    // total of subscribers of your newsletter

$post = ($_SERVER['REQUEST_METHOD'] == 'POST');
if ($post) {
    $start_with  = (int)$_POST["start_with"];
    $error_count = (int)$_POST["error_count"];
} else {
    $start_with  = 0;
    $error_count = 0;
}

$sent = 0;
if ($total_subscribers >= $start_with)
{
    // retrieve all necessary data in the database
    _sleep(0);          // process simulation

    // if new data are available, then ...
    $sent = $maximum_send;
    // else, $error_count++;
}
$start_with += $sent;

// set the new progress value
$complete = round($start_with / $total_subscribers * 100);
$pb->setLabelAttributes('pct1', array('value' => intval($complete)));

$pb->setLabelAttributes($labelTxtID, array(
    'value' => sprintf('Mails sent: %s/%s', $start_with, $total_subscribers)
));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Mailer no timeout Progress2_Lite example</title>
<style type="text/css">
<!--
body {
    background-color: #E0E0E0;
    color: #000000;
    font-family: Verdana, Arial;
}
// -->
</style>
<script type="text/javascript">
<!--

var wait = 0;  // wait one second = 1000

// Pause for N milliseconds to display the progress meter
function pause()
{
    setTimeout("submitForm();", wait);
}

// Submit the form with the new value range
function submitForm()
{
    var complete = parseInt(document.forms[0].complete.value);
    if (complete < 100) {   // re-submit the form if the job is not done
        document.forms[0].submit();
    }
}
//-->
</script>
</head>
<body onLoad="pause();">
<form name="form" method="post"
      action="<?php echo basename($_SERVER['PHP_SELF']) ?>">
<input type="hidden" name="start_with" value="<?php echo $start_with; ?>"/>
<input type="hidden" name="error_count" value="<?php echo $error_count; ?>"/>
<input type="hidden" name="complete" value="<?php echo $complete; ?>"/>
</form>

<?php
if ($complete < 100) {
    $pb->display();
    $pb->moveStep(intval($complete));
} else {
    $pb->hide();
    printf('<p>Mailing Process Ended with %d error(s)</p>', $error_count);
}
?>

</body>
</html>