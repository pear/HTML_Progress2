<?php
/**
 * Display horizontal progress meter into html page
 * built with ITX template system file.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/Renderer/ITStatic.php';
require_once 'HTML/Template/ITX.php';
require_once 'HTML/Progress2.php';

/**
 *  The progress bar display messages
 *  of a software installation simulation.
 *
 *  @param int     $pValue   current value of the progress bar
 *  @param object  $pBar     the progress bar itself
 */
function myFunctionHandler($pValue, &$pBar)
{
    $pBar->sleep();
    $str = ' ';

    if ($pValue > 25) {
        $str = ' - DB schema generated';
    }
    if ($pValue > 50) {
        $str = ' - Config file created';
    }
    if ($pValue == 100) {
        $str = ' - All done !';
    }
    $caption = sprintf('Installation in progress ... %01s%s %s',
                       $pValue,
                       '%',
                       $str);
    $pBar->setLabelAttributes('txt1', array('value' => $caption));
}

$tpl = new HTML_Template_ITX('.');
$tpl->loadTemplateFile('itxstatic.html');

$vars = array (
    'setup_title_label'   => 'SW4P',
    'app_copyright_label' => '&copy; 2003 SW4P Team ',
);
$tpl->setVariable($vars);

$form = new HTML_QuickForm('form');
$form->addElement('submit', 'launch', 'Launch', 'style="width:100px;"');

$styles = array(
  'none'   => 'none',
  'solid'  => 'solid',
  'dashed' => 'dashed',
  'dotted' => 'dotted',
  'inset'  => 'inset',
  'outset' => 'outset'
);
$form->addElement('select', 'border', 'border style:', $styles);

$colors = array('#FFFFFF' => 'white', '#0000FF'=> 'blue', '#7B7B88' => '#7B7B88');
$form->addElement('select', 'color', 'border color:', $colors);

$defaultValues['border'] = 'solid';
$defaultValues['color']  = '#7B7B88';
$form->setDefaults($defaultValues);

if ($form->validate()) {
    $arr = $form->getElementValue('border');
    $border = $arr[0];
    $arr = $form->getElementValue('color');
    $color = $arr[0];
} else {
    $border = $defaultValues['border'];
    $color  = $defaultValues['color'];
}

$pb = new HTML_Progress2(null, HTML_PROGRESS2_BAR_HORIZONTAL, 0, 100, false);
$pb->setAnimSpeed(200);
$pb->setIncrement(5);
$pb->setCellAttributes('active-color=#7B7B88 inactive-color=#D0D0D0 width=20');
$pb->setBorderPainted(true);
$pb->setBorderAttributes(array(
    'width' => 2,
    'color' => $color,
    'style' => $border
));

// Adds additional text label
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'txt1');
$pb->setLabelAttributes('txt1', array(
    'font-size' => 10,
    'width' => 320,
    'left' => 0,
    'valign' => 'bottom'
));
$pb->setProgressHandler('myFunctionHandler');

$tpl->setVariable('stylesheet_html', $pb->getStyle());
$tpl->setVariable('javascript_html', $pb->getScript());
$tpl->setVariable('progress_bar_html', $pb->toHtml());

$renderer = new HTML_QuickForm_Renderer_ITStatic($tpl);
$form->accept($renderer);
$tpl->show();

if ($form->validate()) {
    $pb->run();
}
?>