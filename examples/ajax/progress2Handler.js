/**
 * JavaScript functions to handle standard behaviors of a progress meter
 *
 * @category   HTML
 * @package    HTML_Progress2
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2007 Laurent Laville
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: progress2Handler.js,v 1.1 2007-01-16 15:21:09 farell Exp $
 * @since      File available since Release 2.3.0a1
 */

/**
 * - setProgress -
 *
 * Highlight the right cells depending of progress current value
 *
 * @param      string   pIdent         progress meter html identifier
 * @param      int      pValue         cell number to hightlight
 * @param      int      pDeterminate   tell if we are in indeterminate mode
 *
 * @return     void
 * @public
 * @since      2.0.0
 */
function setProgress(pIdent, pValue, pDeterminate)
{
    var name  = 'pbar' + pIdent;
    var pbar  = document.getElementById(name);
    var cells = pbar.getElementsByTagName('div');

    if (pValue == pDeterminate) {
        for (var i = 0; i < cells.length; i++) {
            showCell(i, pIdent, 'I');
        }
    }
    if ((pDeterminate > 0) && (pValue > 0)) {
        var i = (pValue - 1) % cells.length;
        showCell(i, pIdent, 'A');
    } else {
        for (var i = pValue - 1; i >= 0; i--) {
            showCell(i, pIdent, 'A');
        }
    }
}

/**
 * - showCell -
 *
 * Decide to highlight a cell depending of its status (active, inactive)
 *
 * @param      int      pCell          cell position (0 to cell count - 1) to highlight
 * @param      string   pIdent         progress meter html identifier
 * @param      string   pVisibility    'A' if we highlight active cell, 'I' for inactive cell
 *
 * @return     void
 * @public
 * @since      2.0.0
 */
function showCell(pCell, pIdent, pVisibility)
{
    var name = 'pcel' + pCell + pIdent;
    var cellElement = document.getElementById(name);
    cellElement.className = 'cell' + pVisibility;
//    cellElement.className = 'cell' + pIdent + pVisibility;
}

/**
 * - hideProgress -
 *
 * Remove from display a progress meter
 *
 * @param      string   pIdent         progress meter html identifier
 *
 * @return     void
 * @public
 * @since      2.0.0
 */
function hideProgress(pIdent)
{
    var tfrm = document.getElementById(pIdent);
    tfrm.style.visibility = "hidden";
}

/**
 * - setLabelText -
 *
 * Display new text value of a label
 *
 * @param      string   pIdent         progress meter html identifier
 * @param      string   pName          label identifier
 * @param      string   pText          new value of label to display
 *
 * @return     void
 * @public
 * @since      2.0.0
 */
function setLabelText(pIdent, pName, pText)
{
    var name = 'plbl' + pName + pIdent;
    document.getElementById(name).firstChild.nodeValue = pText;
}

/**
 * - setElementStyle -
 *
 * Handle highlight of a smooth progress bar (without cell)
 *
 * @param      string   pIdent    progress meter html identifier
 * @param      string   pStyles   CSS string to apply
 *
 * @return     void
 * @public
 * @since      2.0.0
 */
function setElementStyle(pIdent, pStyles)
{
    var name = 'pbar' + pIdent;
    var styles = pStyles.split(';');
    styles.pop();
    for (var i = 0; i < styles.length; i++) {
        var s = styles[i].split(':');
        var c = 'document.getElementById(name).style.' + s[0] + '="' + s[1] + '"';
        eval(c);
    }
}

/**
 * - setRotaryCross -
 *
 * Handle special effect for CROSS label type
 *
 * @param      string   pIdent    progress meter html identifier
 * @param      string   pName     cross label identifier
 *
 * @return     void
 * @public
 * @since      2.0.0
 */
function setRotaryCross(pIdent, pName)
{
    var name = 'plbl' + pName + pIdent;
    var cross = document.getElementById(name).firstChild.nodeValue;
    switch(cross) {
        case "--": cross = "\\"; break;
        case "\\": cross = "|"; break;
        case "|": cross = "/"; break;
        default: cross = "--"; break;
    }
    document.getElementById(name).firstChild.nodeValue = cross;
}