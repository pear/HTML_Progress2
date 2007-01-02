function setProgress(pIdent, pValue, pDeterminate, pCellCount)
{
    if (pValue == pDeterminate) {
        for (var i = 0; i < pCellCount; i++) {
            showCell(i, pIdent, 'I');
        }
    }
    if ((pDeterminate > 0) && (pValue > 0)) {
        var i = (pValue - 1) % pCellCount;
        showCell(i, pIdent, 'A');
    } else {
        for (var i = pValue - 1; i >= 0; i--) {
            showCell(i, pIdent, 'A');
            var name = 'pcel' + i + pIdent;
            document.getElementById(name).innerHTML = i;
        }
    }
}

function showCell(pCell, pIdent, pVisibility)
{
    var name = 'pcel' + pCell + pIdent;
    var cellElement = document.getElementById(name);
    cellElement.className = 'cell' + pIdent + pVisibility;
}

function hideProgress(pIdent)
{
    var name = 'tfrm' + pIdent;
    var tfrm = document.getElementById(name);
    tfrm.style.visibility = "hidden";
}

function setLabelText(pIdent, pName, pText)
{
    var name = 'plbl' + pName + pIdent;
    document.getElementById(name).firstChild.nodeValue = pText;
}

function setElementStyle(pPrefix, pName, pIdent, pStyles)
{
    var name = pPrefix + pName + pIdent;
    var styles = pStyles.split(';');
    styles.pop();
    for (var i = 0; i < styles.length; i++) {
        var s = styles[i].split(':');
        var c = 'document.getElementById(name).style.' + s[0] + '="' + s[1] + '"';
        eval(c);
    }
}

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