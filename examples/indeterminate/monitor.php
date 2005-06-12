<?php
/**
 * Horizontal progress bar in indeterminate mode
 * using the Progress2_Monitor solution (with QF renderer).
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2/Monitor.php';

/**
 *  The progress bar will switch from indeterminate to determinate mode
 *  after reached arbitrary internal step 240.
 *
 *  @param int     $pValue   current value of the progress bar
 *  @param object  $pMon     the progress monitor itself
 */
function myProgressHandler($pValue, &$pMon)
{
    static $c;

    if (!isset($c)) {
        $c = 0;
    }
    $c += 16;
    $pMon->setCaption('completed %step% out of 400', array('step' => $c));

    $pBar =& $pMon->getProgressElement();
    $pBar->sleep();

    if ($c >= 240 && $pBar->isIndeterminate()) {
        $pBar->setIndeterminate(false);
        $pBar->setValue(0);
    }
    if ($pBar->getPercentComplete() == 1) {
        if ($pBar->isIndeterminate()) {
            $pBar->setValue(0);
        }
    }
}

$pm = new HTML_Progress2_Monitor('frmMonitor',
    array( 'button' => array('style' => 'width:80px;'),
           'title'  => 'Progress ...' )
);
$pm->setProgressHandler('myProgressHandler');

$pb =& $pm->getProgressElement();
$pb->setAnimSpeed(200);
$pb->setIncrement(10);
$pb->setProgressAttributes('background-color=#E0E0E0');
$pb->setCellAttributes('active-color=#996');
$pb->setLabelAttributes('pct1', 'color=#996');
$pb->setLabelAttributes('monitorStatus', 'color=black font-size=10');
$pb->setIndeterminate(true);

$pm->setProgressElement($pb);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Half Indeterminate Monitor Progress2 example</title>
<style type="text/css">
<!--
body {
    background-color: #444444;
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
  <table width="450" border="0" cellpadding="3" cellspacing="2" bgcolor="#CCCC99">
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
  <td style="background:#996;color:#ffc;" align="left" colspan="2">
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