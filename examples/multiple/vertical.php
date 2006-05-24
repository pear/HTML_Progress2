<?php
/**
 * Multiple Vertical progress bar.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/multiple/vertical.php
 *             vertical source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/vertical.png
 *             screenshot (Image PNG, 261x265 pixels) 2.59 Kb
 */
require_once 'HTML/Progress2.php';

$pb1 = new HTML_Progress2();
$pb1->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
$pb1->setIdent('PB1');
$pb1->setAnimSpeed(100);
$pb1->setIncrement(10);
$pb1->setProgressAttributes('position=absolute top=5 left=30');
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
    'top' => 230
));

$pb2 = new HTML_Progress2();
$pb2->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
$pb2->setIdent('PB2');
$pb2->setAnimSpeed(80);
$pb2->setIncrement(5);
$pb2->setFillWay('reverse');
$pb2->setProgressAttributes('position=absolute top=5 left=120');
$pb2->setCellCount(15);
$pb2->setCellAttributes('active-color=#3874B4 inactive-color=#FFDDAA width=50 height=13');
$pb2->setBorderPainted(true);
$pb2->setBorderAttributes('width=1 style=dashed');
$pb2->setLabelAttributes('pct1', array(
    'font-size' => 8,
    'color' => 'navy',
    'align' => 'center',
    'top' => 230
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

div.container {
    position: absolute;
    left: 40px;
    top: 80px;
    width: 210px;
    height: 250px;
    border: 4px;
    border-color: navy;
    border-style: dotted;
}
 -->
</style>
<?php echo $pb1->getScript(false); ?>
</head>
<body>

<div class="container">
<?php
$pb1->display();
$pb2->display();
?>
</div>

<?php
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