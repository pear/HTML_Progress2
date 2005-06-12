<!--
  Demonstration of the basic features of Progress2_Lite
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
<title>Progress2 Lite - Simple Example</title>
</head>
<body bgcolor="#E0E0E0">
<p style="background-color:white;width:400px;height:200px;">&nbsp;</p>
<h1>Positionning sheme</h1>
<p>Default behaviour.</p>

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

// Creates a new progress bar 300 pixels width and 30 pixels height
$pbl = new HTML_Progress2_Lite(array('top' => 80, 'left' => 50, 'height' => 30));

// Adds additional text label
$pbl->addLabel('text','txt1','Progress2 Lite - Simple Example');

// Show the progress bar
$pbl->display();

// Processes
for($i=1; $i<=100; $i++) {
    $pbl->moveStep($i);
    _sleep(100000);
}
?>
</body>
</html>