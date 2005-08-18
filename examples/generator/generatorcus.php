<?php
/**
 * HTML_Progress2_Generator embedded into existing html page
 * and allows php/css source-code download.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2/Generator.php';

/* 1. Choose between standard renderers (default, HTMLPage2, ITDynamic).
      If none is selected, then 'default' will be used.
      It can be automatically loaded and added by the controller
 */
require_once 'HTML/Progress2/Generator/ITDynamic.php';

/* 2. 'ActionDisplay' is default classname that should exists
      to manage wizard/tabbed display. But you can also create
      your own class under a new name. Then you've to give
      the new name to HTML_Progress2_Generator.
      For example:

      class MyDisplayHandler extends HTML_QuickForm_Action_Display
      {
           ...
      }
      If your 'MyDisplayHandler' class is not defined, then default
      'ActionDisplay' ('HTML/Progress2/Generator/Default.php')
      will be used.
 */

/**
 * @ignore
 */
class MyDisplayHandler extends HTML_QuickForm_Action_Display
{
    function _renderForm(&$page)
    {
        $pageName = $page->getAttribute('name');
        $tabPreview = array_slice ($page->controller->_tabs, -2, 1);

        $tpl =& new HTML_Template_Sigma('.', 'cache/');
        $tpl->loadTemplateFile('itdynamic.html');

        // on preview tab, add progress bar javascript and stylesheet
        if ($pageName == $tabPreview[0][0]) {
            $pb = $page->controller->createProgressBar();

            $tpl->setVariable(array(
                'qf_style'  => $pb->getStyle(),
                'qf_script' => $pb->getScript()
                )
            );

            $pbElement =& $page->getElement('progressBar');
            $pbElement->setText($pb->toHtml() . '<br /><br />');
        }

        $renderer =& new HTML_QuickForm_Renderer_ITDynamic($tpl);
        $renderer->setElementBlock(array('buttons' => 'qf_buttons'));

        $page->accept($renderer);
        $tpl->show();
    }
}

/* 3. 'ActionProcess' is default classname that should exists
      to save your progress bar php/css source-code. But you can also create
      your own class under a new name. Then you've to give
      the new name to HTML_Progress2_Generator.
      For example:

      class MyProcessHandler extends HTML_QuickForm_Action
      {
           ...
      }
      If your 'MyProcessHandler' class is not defined, then default
      'ActionProcess' ('HTML/Progress2/Generator/Process.php')
      will be used.
 */
require_once 'HTML/Progress2/Generator/Process.php';

/**
 * @ignore
 */
class MyProcessHandler extends ActionProcess
{
    function perform(&$page, $actionName)
    {
        if ($actionName == 'cancel') {
            echo '<h1>Progress2 Generator Demonstration is Over</h1>';
            echo '<p>Hope you\'ve enjoyed. See you later!</p>';
        } else {
            // Checks whether the pages of the controller are valid
            $page->isFormBuilt() or $page->buildForm();
            $page->controller->isValid();

            // what kind of source code is requested
            $code = $page->exportValue('phpcss');
            $pb = $page->controller->createProgressBar();

            $phpCode = (isset($code['P']) === true);
            $cssCode = (isset($code['C']) === true);

            if ($cssCode && !$phpCode) {
                $strCSS = $this->sprintCSS($pb);
                $this->exportOutput($strCSS, 'text/css');
            }
            if ($phpCode) {
                $strPHP = $this->sprintPHP($pb, $cssCode);
                $this->exportOutput($strPHP, 'text/php');
            }

            // reset session data
            $page->controller->container(true);
        }
    }
}

session_start();

$tabbed = new HTML_Progress2_Generator('PBwizard',
    array('display' => 'MyDisplayHandler', 'process' => 'MyProcessHandler')
);
$tabbed->run();
?>