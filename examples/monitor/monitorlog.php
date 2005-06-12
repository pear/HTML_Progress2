<?php
/**
 * Progress2 Monitor with default QF renderer
 * and a user callback for logging events.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2/Monitor.php';

function logger($pValue, &$pMon)
{
    static $time_start;

    $pb =& $pMon->getProgressElement();
    $pb->sleep();

    if (!isset($time_start)) {
        $time = explode(' ', microtime());
        $time_start = $time[1] + $time[0];

    } elseif (fmod($pValue,25) == 0) {
        $time = explode(' ', microtime());
        $elapse = $time[1] + $time[0] - $time_start;
        $pMon->setCaption('%value%% has been reached on %time% sec.',
            array('value' => $pValue, 'time' => sprintf('%01.3f',$elapse))
        );
    }
}

$pm = new HTML_Progress2_Monitor();
$pm->setProgressHandler('logger');

$pb =& $pm->getProgressElement();
$pb->setAnimSpeed(100);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Logger Progress2 Monitor </title>
<style type="text/css">
<!--
<?php echo $pm->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $pm->getScript(); ?>
//-->
</script>
</head>
<body>

<?php
echo $pm->toHtml();
$pm->run();
?>

</body>
</html>