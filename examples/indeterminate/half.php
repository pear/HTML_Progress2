<?php
/**
 * Horizontal progress bar in indeterminate mode
 * without using the Progress2_Monitor solution.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2.php';

/**
 *  The progress bar will switch from indeterminate to determinate mode
 *  after a 12 seconds time elapsed.
 *
 *  @param int     $pValue   current value of the progress bar
 *  @param object  $pBar     the progress bar itself
 */
function myProgressHandler($pValue, &$pBar)
{
    static $c, $t;

    if (!isset($c)) {
        $c = time();
        $t = 0;
    }

    $pBar->sleep();

    if ($pBar->isIndeterminate()) {
        $elapse = time() - $c;

        if ($elapse > $t) {
            echo "myProgressHandler -> elapse time = $elapse s.<br />\n";
            $t++;
        }
        if ($elapse >= 12) {
            $pBar->setIndeterminate(false);
            $pBar->setValue(0);
            $pBar->setIncrement(5);
        }
    }
}

$pb = new HTML_Progress2();
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
$pb->setProgressAttributes('background-color=#E0E0E0');
$pb->setCellAttributes('active-color=#996');
$pb->setLabelAttributes('pct1', array('color' => '#996'));
$pb->setIndeterminate(true);
$pb->setProgressHandler('myProgressHandler');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Half Indeterminate Progress2 example</title>
<style type="text/css">
<!--
body {
    background-color: #CCCC99;
    color: #996;
    font-family: Verdana, Arial;
}

<?php echo $pb->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $pb->getScript(); ?>
//-->
</script>
</head>
<body>

<?php
$pb->display();
echo '<br /><br />';
$pb->run();
?>
<p><b>Process Ended !</b></p>

</body>
</html>