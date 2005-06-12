
function setProgress(pIdent, pValue, pDeterminate, pCellCount)
{
    if (pValue == pDeterminate) {
        for (i=0; i < pCellCount; i++) {
            showCell(i, pIdent, 'hidden');
        }
    }
    if ((pDeterminate > 0) && (pValue > 0)) {
        i = (pValue - 1) % pCellCount;
        showCell(i, pIdent, 'visible');
    } else {
        for (i = pValue - 1; i >=0; i--) {
            showCell(i, pIdent, 'visible');
            name = 'pcel' + i + 'A' + pIdent;
            document.getElementById(name).innerHTML = i;
        }
    }
}

function showCell(pCell, pIdent, pVisibility)
{
    name = 'pcel' + pCell + 'A' + pIdent;
    document.getElementById(name).style.visibility = pVisibility;
}

function hideProgress(pIdent, pCellCount)
{
    document.getElementById('tfrm'+pIdent).style.visibility = 'hidden';
    for (i = 0; i < pCellCount; i++) {
        showCell(i, pIdent, 'hidden');	
    }
}

function setLabelText(pIdent, pName, pText) 
{
    name = "plbl" + pName + pIdent;
    document.getElementById(name).firstChild.nodeValue = pText;
}

function setElementStyle(pPrefix, pName, pIdent, pStyles) 
{
    name = pPrefix + pName + pIdent;
    styles = pStyles.split(';');
    styles.pop();
    for (i = 0; i < styles.length; i++)
    {
        s = styles[i].split(':');
        c = 'document.getElementById(name).style.' + s[0] + '="' + s[1] + '"';
        eval(c);
    }
}
