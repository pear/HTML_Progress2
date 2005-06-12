<!--
  Demonstration of all the features of Progress2_Lite
  version of Progress2 without any dependencies

  @version    $Id$
  @author     Laurent Laville <pear@laurent-laville.org>
  @package    HTML_Progress2
  @subpackage Examples
  @access     public
// -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Progress2 Lite - Full features </title>
</head>
<body>
<?php
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

$opt1 = array('left' => 50, 'top' => 50, 'width' => 40, 'height' => 270,
    'padding' => 2,
    'max' => 220
);
$pbl1 = new HTML_Progress2_Lite($opt1);
$pbl1->addLabel('percent','pct1');
$pct1 = array('left' => 50, 'top', 35, 'width' => 40);
$pbl1->setLabelAttributes('pct1', $pct1);
$pbl1->setDirection('down');
$pbl1->display();

$opt2 = array('left' => 120, 'top' => 50, 'height' => 40);
$pbl2 = new HTML_Progress2_Lite($opt2);
$pbl2->setBarAttributes(array(
    'border-width' => 2,
    'border-color' => '#660066',
    'color' => '#6699FF',
    'background-color' => '#000000'
));
$pbl2->addLabel('crossbar','crt1');
$crt1 = array('left' => 120, 'top' => 30);
$pbl2->setLabelAttributes('crt1', $crt1);
$pbl2->display();

$opt3 = array('left' => 120, 'top' => 120, 'width' => 400, 'height' => 70);
$pbl3 = new HTML_Progress2_Lite($opt3);
$pbl3->setBarAttributes(array(
    'color' => '#FF6633',
    'background-color' => 'yellow'
));
$pbl3->setDirection('left');
$pbl3->addLabel('text','txt1');
$pbl3->setLabelAttributes('txt1', array('color' => 'orange'));
$pbl3->display();

$opt4 = array('left' => 120, 'top' => 220, 'width' => 600, 'height' => 100,
    'min' => 50,
    'max' => 150
);
$pbl4 = new HTML_Progress2_Lite($opt4);
$pbl4->setBarAttributes(array(
    'border-width' => 0,
    'color' => '#CCCC66',
    'background-color' => '#66CCFF'
));
$pbl4->addLabel('percent','pct1');
$pct1 = array('left' => 120, 'top' => 220, 'width' => 600, 'height' => 100,
    'align' => 'center',
    'font-size' => 78
);
$pbl4->setLabelAttributes('pct1', $pct1);
$pbl4->display();

@set_time_limit(300);

for($i=1; $i<=220; $i++) {
    $pbl1->moveStep($i);
    if ($i==50) {$pbl2->hide();}
    if ($i==100) {$pbl3->hide();}
    if ($i==200) {$pbl4->hide();}
    _sleep(10000);
}
$pbl1->moveMin();
$pbl1->setDirection('up');

$pbl2->show();
for($i=1; $i<=100; $i++) {
    $pbl2->moveStep($i);
    $crt1 = array('left' => ($i * 3) + 120, 'top' => 30,
        'width' => 10, 'height' => 0,
        'align' => 'center');
    $pbl2->setLabelAttributes('crt1', $crt1);
    $pbl2->setBarAttributes(array(
        'color' => '#00'.dechex(100-$i+100).dechex($i+80)
    ));
    $pbl1->moveNext();
    _sleep(100000);
}
$pbl2->setLabelAttributes('crt1', array('value' => ''));

$pbl3->show();
$pbl3->setLabelAttributes('txt1', array('value' => 'searching ...'));
for($i=1; $i<=100; $i++) {
    if($i==30) {
        $pbl3->setLabelAttributes('txt1', array('value' => 'loading ...'));
    }
    if($i==60) {
        $pbl3->setLabelAttributes('txt1', array('value' => 'writing ...'));
    }
    $pbl3->moveStep($i);
    $pbl1->moveNext();
    _sleep(100000);
}
$pbl3->setLabelAttributes('txt1', array('value' => 'complete'));

$pbl4->show();
for($i=50; $i<=150; $i+=5) {
    $pbl4->moveStep($i);
    $pbl1->moveNext();
    sleep(1);
}
?>
</body>
</html>