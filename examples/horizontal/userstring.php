<?php
/**
 * Horizontal progress bar with custom string
 * rather than percent text info.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/horizontal/userstring.php
 *             userstring source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/userstring.png
 *             screenshot (Image PNG, 440x30 pixels) 572 bytes
 */
require_once 'HTML/Progress2.php';

$pkg = array('PEAR', 'Archive_Tar', 'Config',
    'HTML_QuickForm', 'HTML_CSS', 'HTML_Page', 'HTML_Template_Sigma',
    'Log', 'MDB', 'PHPUnit');

function myFunctionHandler($pValue, &$pBar)
{
    global $pkg, $labelID1;

    $pBar->sleep();

    $i = floor($pValue / 10);
    if ($pValue == 100) {
        $msg = 'installation complete';
    } else {
        $msg = "installing package ($pValue %) ... : ".$pkg[$i];
    }
    $pBar->setLabelAttributes($labelID1, array('value' => $msg));
}

$pb = new HTML_Progress2(null, HTML_PROGRESS2_BAR_HORIZONTAL, 0, 100, false);
$pb->setAnimSpeed(200);
$pb->setIncrement(5);
$labelID1 = 'txt1';
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, $labelID1);
$pb->setLabelAttributes($labelID1, 'valign=right');
$pb->setProgressHandler('myFunctionHandler');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>UserString Progress2 example</title>
<style type="text/css">
<!--
<?php echo $pb->getStyle(); ?>

body {
    background-color: #FFFFFF;
}
// -->
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