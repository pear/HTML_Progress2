<?php
/**
 * The ActionDisplay class provides a HTML_Page2 form rendering.
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

require_once 'HTML/Page2.php';

/**
 * The ActionDisplay class provides a HTML_Page2 form rendering.
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

        $p = new HTML_Page2(array(
                 'lineend'  => PHP_EOL,
                 'doctype'  => 'XHTML 1.0 Strict',
                 'language' => 'en',
                 'cache'    => 'false'
             ));        
        $p->disableXmlProlog();
        $p->setTitle('PEAR::HTML_Progress2 - Generator');
        $p->setMetaData('author', 'Laurent Laville');

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
        $css->setStyle('th', 'text-align', 'center');
        $css->setStyle('th', 'color', '#FFC');
        $css->setStyle('th', 'background-color', '#AAA');
        $css->setStyle('th', 'white-space', 'nowrap');
        $css->setStyle('input', 'font-family', 'Verdana, Arial, helvetica');
        $css->setStyle('input.flat', 'border-style', 'solid');
        $css->setStyle('input.flat', 'border-width', '2px 2px 0px 2px');
        $css->setStyle('input.flat', 'border-color', '#996');

        // on preview tab, add progress bar javascript and stylesheet
        if ($pageName == $tabPreview[0][0]) {
            $pb = $page->controller->createProgressBar();

            $p->addStyleDeclaration( $css->toString() . $pb->getStyle() );
            $p->addScriptDeclaration( $pb->getScript() );

            $pbElement =& $page->getElement('progressBar');
            $pbElement->setText($pb->toHtml() . '<br /><br />');
        } else {
            $p->addStyleDeclaration( $css->toString() );
        }

        $renderer =& $page->defaultRenderer();

        $renderer->setFormTemplate('<table class="maintable"><form{attributes}>{content}</form></table>');
        $renderer->setHeaderTemplate('<tr><th colspan="2">{header}</th></tr>');
        $renderer->setGroupTemplate('<table><tr>{content}</tr></table>', 'name');
        $renderer->setGroupElementTemplate('<td>{element}<br /><span style="font-size:10px;"><span class="label">{label}</span></span></td>', 'name');
        $renderer->setElementTemplate("\n\t<tr>\n\t\t<td align=\"right\" valign=\"top\" width=\"30%\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required --><b>{label}</b></td>\n\t\t<td valign=\"top\" align=\"left\"><!-- BEGIN error --><span style=\"color: #ff0000\">{error}</span><br /><!-- END error -->\t{element}</td>\n\t</tr>");

        $page->accept($renderer);

        $p->addBodyContent( $renderer->toHtml() );
	$p->display();
    }
}
?>