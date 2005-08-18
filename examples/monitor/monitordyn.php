<?php
/**
 * Progress2 Monitor using ITDynamic QF renderer,
 * and a class-method as user callback.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/monitor/monitordyn.php
 *             monitordyn source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/monitordyn.png
 *             screenshot (Image PNG, 623x154 pixels) 3.59 Kb
 */
require_once 'HTML/Progress2/Monitor.php';
require_once 'HTML/QuickForm/Renderer/ITDynamic.php';
require_once 'HTML/Template/Sigma.php';
/**
 * @ignore
 */
class myClassHandler
{
    function myMethod($pValue, &$pb)
    {
        global $pm;

        switch ($pValue) {
         case 10:
            $pic = 'picture1.jpg';
            break;
         case 45:
            $pic = 'picture2.jpg';
            break;
         case 70:
            $pic = 'picture3.jpg';
            break;
         default:
            $pic = null;
        }
        if (!is_null($pic)) {
            $pm->setCaption('upload %file% in progress ... '
                          . 'Start at %percent%%',
                            array('file' => $pic, 'percent' => $pValue)
            );
        }
        $pb->sleep();
    }
}

$pm = new HTML_Progress2_Monitor('frmMonitor5', array(
    'title'  => 'Upload your pictures',
    'start'  => 'Upload',
    'cancel' => 'Stop',
    'button' => array('style' => 'width:80px;')
));

$pb =& $pm->getProgressElement();
$pb->setAnimSpeed(50);
$pb->setCellCount(20);
$pb->setProgressAttributes('background-color=#EEE');
$pb->setCellAttributes('inactive-color=#FFF active-color=#444444');
$pb->setLabelAttributes('pct1', 'color=navy');
$pb->setLabelAttributes('monitorStatus', 'color=navy font-size=10');
$pb->setProgressHandler(array('myClassHandler','myMethod'));

$pm->setProgressElement($pb);

$tpl =& new HTML_Template_Sigma('.');
$tpl->loadTemplateFile('itdynamic.html');

$tpl->setVariable(array(
    'qf_style'  => $pm->getStyle(),
    'qf_script' => $pm->getScript(false)
    )
);

$renderer =& new HTML_QuickForm_Renderer_ITDynamic($tpl);
$renderer->setElementBlock(array('buttons' => 'qf_buttons'));

$pm->accept($renderer);

$tpl->show();
$pm->run();
?>

</body>
</html>