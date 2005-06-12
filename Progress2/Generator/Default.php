<?php
/**
 * The ActionDisplay class provides the default form rendering.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   HTML
 * @package    HTML_Progress2
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/HTML_Progress2
 */


/**
 * The ActionDisplay class provides the default form rendering.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   HTML
 * @package    HTML_Progress2
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/HTML_Progress2
 */

class ActionDisplay extends HTML_QuickForm_Action_Display
{
    function _renderForm(&$page) 
    {
        $pageName = $page->getAttribute('name');
        $tabPreview = array_slice ($page->controller->_tabs, -2, 1);

        $css = new HTML_CSS();
        $css->setStyle('body', 'background-color', '#7B7B88');
        $css->setStyle('body', 'font-family', 'Verdana, Arial, helvetica');
        $css->setStyle('body', 'font-size', '10pt');
        $css->setStyle('h1', 'color', '#FFC');
        $css->setStyle('h1', 'text-align', 'center');
        $css->setStyle('.maintable', 'width', '100%');
        $css->setStyle('.maintable', 'border-width', '0');
        $css->setStyle('.maintable', 'border-style', 'thin dashed');
        $css->setStyle('.maintable', 'border-color', '#D0D0D0');
        $css->setStyle('.maintable', 'background-color', '#EEE');
        $css->setStyle('.maintable', 'cellspacing', '2');
        $css->setStyle('.maintable', 'cellspadding', '3');
        $css->setStyle('.groupelement', 'font-size', '8pt');
        $css->setStyle('.groupelement', 'cellspacing', '5');
        $css->setStyle('th', 'text-align', 'center');
        $css->setStyle('th', 'color', '#FFC');
        $css->setStyle('th', 'background-color', '#AAA');
        $css->setStyle('th', 'white-space', 'nowrap');
        $css->setStyle('input', 'font-family', 'Verdana, Arial, helvetica');
        $css->setStyle('input.flat', 'border-style', 'solid');
        $css->setStyle('input.flat', 'border-width', '2px 2px 0px 2px');
        $css->setStyle('input.flat', 'border-color', '#996');

$header = '
<style type="text/css">
<!--
{%style%}
// -->
</style>
';
        // on preview tab, add progress bar javascript and stylesheet
        if ($pageName == $tabPreview[0][0]) {
            $pb = $page->controller->createProgressBar();

            $header .= '
<script type="text/javascript">
<!--
{%javascript%}
//-->
</script>
';
            $header = str_replace('{%style%}', $css->toString() . $pb->getStyle(), $header);
            $header = str_replace('{%javascript%}', $pb->getScript(), $header);

            $pbElement =& $page->getElement('progressBar');
            $pbElement->setText($pb->toHtml() . '<br /><br />');
        
        } else {
            $header = str_replace('{%style%}', $css->toString(), $header);
        }

        $formTemplate = "\n<form{attributes}>"
                      . "\n<table style=\"font-size: 8pt;\" class=\"maintable\">"
                      . "\n{content}"
                      . "\n</table>"
                      . "\n</form>";

        $headerTemplate = "\n<tr>"
                        . "\n\t<th colspan=\"2\">"
                        . "\n\t\t{header}"
                        . "\n\t</th>"
                        . "\n</tr>";
        
        $elementTemplate = "\n<tr valign=\"top\">"
                         . "\n\t<td align=\"right\" width=\"30%\"><b>{label}</b></td>"
                         . "\n\t<td align=\"left\">"
                         . "\n{element}"
                         . "<!-- BEGIN label_2 -->&nbsp;"
                         . "<span style=\"font-size:90%;\">{label_2}</span>"
                         . "<!-- END label_2 -->"
                         . "\n\t</td>"
                         . "\n</tr>";

        $groupTemplate = "\n\t\t<table style=\"font-size:8pt;\">"
                       . "\n\t\t<tr>"
                       . "\n\t\t\t{content}"
                       . "\n\t\t</tr>"
                       . "\n\t\t</table>";

        $groupElementTemplate = "<td>{element}"
                              . "<!-- BEGIN label --><br/>"
                              . "<span style=\"font-size:90%;\">{label}</span>"
                              . "<!-- END label -->"
                              . "</td>";

        $renderer =& $page->defaultRenderer();

        $renderer->setFormTemplate($formTemplate);
        $renderer->setHeaderTemplate($headerTemplate);
        $renderer->setElementTemplate($elementTemplate);

        $groups = array('progresssize',                                   // on page 1
                        'cellvalue','cellsize', 'cellcolor', 'cellfont',  // on page 2
                        'borderstyle',                                    // on page 3
                        'stringsize','stringfont'                         // on page 4
                       );
                       
        foreach ($groups as $grp) {
            $renderer->setGroupTemplate($groupTemplate, $grp);
            $renderer->setGroupElementTemplate($groupElementTemplate, $grp);
        }
  
        $page->accept($renderer);

        echo $header;
        echo $renderer->toHtml();
    }
}
?>