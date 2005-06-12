<?php
/**
 * Progress2 Monitor
 * with a new form template and progress bar color layout.
 * Used a function as user callback.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2/Monitor.php';

/**
 * In case we have attached an indeterminate progress bar to the monitor
 * once we have reached 60%,
 * we swap from indeterminate mode to determinate mode
 * and run a standard progress bar from 0 to 100%
 *
 *  @param int     $pValue   current value of the progress bar
 *  @param object  $pMon     the progress monitor itself
 */
function myFunctionHandler($pValue, &$pMon)
{
    $pb =& $pMon->getProgressElement();
    $pb->sleep();

    if (!$pb->isIndeterminate()) {
        if (fmod($pValue,10) == 0) {
            $pMon->setCaption('myFunctionHandler -> progress value is = %value%',
                array('value' => $pValue)
                );
        }
    } elseif ($pValue == 60) {
        $pb->setIndeterminate(false);
        $pb->setValue(0);
    }
}

$pm = new HTML_Progress2_Monitor('frmMonitor4', array(
    'button' => array('style' => 'width:80px;'),
    'autorun' => true
    )
);
$pm->setProgressHandler('myFunctionHandler');

$pb =& $pm->getProgressElement();
$pb->setAnimSpeed(100);
$pb->setCellCount(20);
$pb->setProgressAttributes('background-color=#EEE');
$pb->setCellAttributes('inactive-color=#FFF active-color=#444444');
$pb->setLabelAttributes('pct1', 'color=navy');
$pb->setLabelAttributes('monitorStatus', 'color=navy font-size=10');
$pb->setIndeterminate(true);

$pm->setProgressElement($pb);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Custom Progress2 Monitor </title>
<style type="text/css">
<!--
body {
    background-color: lightgrey;
    font-family: Verdana, Arial;
}
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
$renderer =& HTML_QuickForm::defaultRenderer();
$renderer->setFormTemplate('
<form{attributes}>
  <table width="450" border="0" cellpadding="3" cellspacing="2" bgcolor="#EEEEEE">
  {content}
  </table>
</form>
');
$renderer->setElementTemplate('
  <tr>
    <td valign="top" style="padding-left:15px;">
    {element}
    </td>
  </tr>
');
$renderer->setHeaderTemplate('
  <tr>
    <td style="background:#7B7B88;color:#ffc;" align="left" colspan="2">
      <b>{header}</b>
    </td>
  </tr>
');
$pm->accept($renderer);

echo $renderer->toHtml();
$pm->run();
?>

</body>
</html>