<?php
/**
 * Mailer no timeout pattern with HTML_Progress2.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/preload/mailer1.php
 *             mailer1 source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/mailer1.png
 *             screenshot (Image PNG, 425x87 pixels) 873 bytes
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setProgressAttributes(array(
    'position' => 'absolute',
    'left' => 200,
    'top' => 100
));
$pb->setCellAttributes(array(
    'active-color' => '#000084',
    'inactive-color' => '#3A6EA5',
    'width' => 32,
    'height' => 32
));
$pb->setLabelAttributes('pct1', array(
    'width' => 0,
    'left' => 350,
    'top' => 10,
    'font-size' => 16,
    'font-weight' => 'bold'
));

// Adds additional text label for process legend
$labelTxtID = 'legend';
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, $labelTxtID);
$pb->setLabelAttributes($labelTxtID, array(
    'left' => 0,
    'top' => -16,
    'color' => 'red'
));

$maximum_send = 5;           // max number of emails to send each page load
$total_subscribers = 500;    // total of subscribers of your newsletter

// step to advance on each page load
$inc = intval($total_subscribers / $maximum_send * 0.01);
$pb->setIncrement($inc);

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
    $pb->sleep();          // process simulation

    // if new data are available, then ...
    $sent = $maximum_send;
    // else, $error_count++;
}
$start_with += $sent;

// set the new progress value
$complete = round($start_with / $total_subscribers * 100);
$pb->setValue(intval($complete));

$pb->setLabelAttributes($labelTxtID, array(
    'value' => sprintf('Mails sent: %s/%s', $start_with, $total_subscribers))
    );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Mailer no timeout Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #E0E0E0;
    color: #000000;
    font-family: Verdana, Arial;
}
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $pb->getScript(); ?>

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
    $pb->moveNext();
} else {
    $pb->hide();
    printf('<p>Mailing Process Ended with %d error(s)</p>', $error_count);
}
?>

</body>
</html>