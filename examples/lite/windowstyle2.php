<?php
/**
 * Demonstration of the windowstyle feature of Progress2_Lite
 * version of Progress2 without any dependencies
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/lite/windowstyle2.php
 *             windowstyle2 source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/litewindowstyle.png
 *             screenshot (Image PNG, 390x300 pixels) 4.21 Kb
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Progress2 Lite - Window Style</title>
</head>
<body>
<h1>Positioning schemes </h1>
<p style="background-color:lightblue;width:320px;height:240px;text-align:center;">
320 x 240
</p>

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

// Creates new progress bar with defaults (300 pixels width and 25 pixels height)
$pbl = new HTML_Progress2_Lite(array('padding' => 2, 'position' => 'relative'));
$pbl->setFrameAttributes(array('left' => 50, 'top' => 180));
$pbl->setBarAttributes(array('border-color' => '#404040 #dfdfdf #dfdfdf #404040'));

// Adds additional text as label 'txt1'
$pbl->addLabel('text','txt1','Please wait ...');

// Adds percent info as label 'pct1'
$pbl->addLabel('percent','pct1');

// Adds restart button as label 'btn1' with action 'restart=1'
$pbl->addButton('btn1','Restart',$_SERVER['PHP_SELF'].'?restart=1');

// Adds stop button as label 'btn2' with action 'stop=1'
$pbl->addButton('btn2','Stop',$_SERVER['PHP_SELF'].'?stop=1');
// and make it right aligned with restart button (shift left 80 pixels)
$pbl->setLabelAttributes('btn2', array('left' => 80));

// Show the progress bar frame
$pbl->display();

if (isset($_GET['stop'])) {
    $messageEnd = 'Canceled';
} else {
    // Processes
    for($i=1; $i<=100; $i++) {
        if ($i==15) {
            $pbl->setLabelAttributes('txt1',
                                     array('value' => 'Loading Demo')
            );
        }
        if ($i==30) {
            $pbl->setLabelAttributes('txt1',
                                     array('value' => 'Scanning ...')
            );
        }
        if ($i>50 && $i<80) {
            $pbl->setLabelAttributes('txt1',
                                     array('value' => 'Send Mail: '.$i.'/130')
            );
        }
        if ($i==80) {
            $pbl->setLabelAttributes('txt1',
                                     array('value' => 'anything else ...')
            );
        }
        $pbl->moveStep($i);
        _sleep(100000);
    }
    $messageEnd = 'Completed';
}
// Finishs operation with final label 'txt1' text value
$pbl->setLabelAttributes('txt1', array('value' => $messageEnd));
?>
</body>
</html>