<?php
/**
 * Multiple mixed progress bar.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2.php';

$pb1 = new HTML_Progress2();
$pb1->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
$pb1->setIdent('PB1');
$pb1->setAnimSpeed(100);
$pb1->setIncrement(10);
$pb1->setProgressAttributes('position=absolute top=90 left=15');
$pb1->setCellCount(15);
$pb1->setCellAttributes('
active-color=#970038 inactive-color=#FFDDAA width=50 height=13
');
$pb1->setBorderPainted(true);
$pb1->setBorderAttributes('width=1');
$pb1->setLabelAttributes('pct1', array(
    'font-size' => 8,
    'color' => '#FF0000',
    'align' => 'center',
    'top' => -16
));

$pb2 = new HTML_Progress2();
$pb2->setIdent('PB2');
$pb2->setAnimSpeed(80);
$pb2->setIncrement(5);
$pb2->setProgressAttributes(array(
    'position' => 'absolute',
    'auto-size' => false,
    'width' => 600,
    'height' => 100,
    'top' => 220,
    'left' => 120
    ));
$pb2->setCellCount(0);
$pb2->setCellAttributes('active-color=#CCCC66 inactive-color=#66CCFF');
$pb2->setLabelAttributes('pct1', array(
    'font-size' => 78,
    'width' => 600,
    'height' => 100,
    'align' => 'center',
    'color' => 'navy'
    ));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Multiple Vertical Progress2 example</title>
<style type="text/css">
<!--
<?php
echo $pb1->getStyle();
echo $pb2->getStyle();
?>

body {
    background-color: #C3C6C3;
}
// -->
</style>
<?php echo $pb1->getScript(false); ?>
</head>
<body>

<?php
$pb1->display();
$pb2->display();

do {
    if ($pb2->getPercentComplete() == 1) {
        break;
    }
    if ($pb1->getPercentComplete() < 1) {
        $pb1->process();
        $pb1->moveNext();
    }
    $pb2->process();
    $pb2->moveNext();
} while(1);
?>

</body>
</html>