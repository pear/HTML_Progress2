<?php
/**
 * Horizontal ProgressBar inside a pseudo window frame.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/label/windowstyle.php
 *             windowstyle source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/labelwindowstyle.png
 *             screenshot (Image PNG, 267x99 pixels) 773 bytes
 */
require_once 'HTML/Progress2.php';

$pb = new HTML_Progress2();
$pb->setAnimSpeed(100);
$pb->setIncrement(10);
$pb->setCellCount(0);
$pb->setProgressAttributes(array(
    'position' => 'absolute',
    'width' => 172,
    'height' => 24
));
$pb->setCellAttributes(array(
    'active-color' => '#0033FF',
    'inactive-color' => '#CCCCCC'
));
$pb->setBorderPainted(true);
$pb->setBorderAttributes(array(
    'width' => 1,
    'color' => '#404040 #dfdfdf #dfdfdf #404040'
));
$pb->setFrameAttributes(array('width' => 200, 'height' => 70));

$pb->setLabelAttributes('pct1', array('left' => 130, 'top' => 9));

// Adds additional text label
$labelID1 = 'txt1';
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, $labelID1, 'Please wait ...');
$pb->setLabelAttributes($labelID1, array('left' => 10, 'top' => 9));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Window Style Frame Progress2 example</title>
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
<?php echo $pb->getScript(false); ?>
</head>
<body>

<?php
$pb->display();

for($i=1; $i<=100; $i++) {
    if ($i==15) {
        $pb->setLabelAttributes($labelID1,
                                array('value' => 'Loading Album')
        );
    }
    if ($i==30) {
        $pb->setLabelAttributes($labelID1,
                                array('value' => 'Scanning ...')
        );
    }
    if ($i>50 && $i<67) {
        $pb->setLabelAttributes($labelID1,
                                array('value' => 'Load Song: '.($i-49).'/16')
        );
    }
    if ($i==67) {
        $pb->setLabelAttributes($labelID1,
                                array('value' => 'anything else ...')
        );
    }
    $pb->moveStep($i);
    $pb->process();
    if ($pb->getPercentComplete() == 1) {
        break;
    }
}
$pb->hide();
?>

<h1>Process ended ! </h1>
<p>Wait is over, and progress meter is hidden.</p>

<h2>Laura Pausini - the best of </h2>
<p>E Ritorno Da Te </p>
<ol>
<li>e ritorno da te
<li>la solitudine
<li>non c'e
<li>strani amori
<li>gente
<li>incancellabile
<li>le cose che vivi
<li>seamisai
<li>ascolta il tuo cuore
<li>mi respuesta
<li>in assenza di te
<li>un'emergenza d'amore
<li>one more time
<li>tra te e il mare
<li> il mio sbaglio piu grande
<li>una storia che vale
</ol>

</body>
</html>