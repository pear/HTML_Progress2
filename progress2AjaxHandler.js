/**
 * JavaScript functions to handle AJAX progress bar.
 *
 * @category   HTML
 * @package    HTML_Progress2
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: progress2AjaxHandler.js,v 1.1 2007-01-15 17:27:28 farell Exp $
 * @since      File available since Release 2.3.0a1
 */

var req = null;
var url1 = null;
var url2 = null;
var reqMethod = 'GET';
var progressId = null;
var taskId = null;
var timeout = 2000;

initRequest();

/**
 * - initRequest -
 *
 * Instantiates XMLHttpRequest object.
 *
 * @return     void
 * @public
 * @since      2.3.0a1
 */
function initRequest()
{
    var msxml = new Array('MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP', 'Microsoft.XMLHTTP');
    try
    {
        // Instantiates XMLHttpRequest in non-IE browsers
        req = new XMLHttpRequest();
    }
    catch(e)
    {
        for (var i = 0; i < msxml.length; i++) {
            try
            {
                // Instantiates XMLHttpRequest for IE and
                req = new ActiveXObject(msxml[i]);
                break;
            }
            catch(e)
            {
            }
        }
    }
    if (req == null) {
        alert("Your browser does not support AJAX");
    }
}

/**
 * - startTask -
 *
 * Negociate a task id:
 * This Id is used by the polling loop to track the progress of the task.
 *
 * @return     void
 * @public
 * @since      2.3.0a1
 */
function startTask()
{
    var dataSend = null;
    var m = reqMethod.toUpperCase();

    if (m == 'GET') {
        // avoid browser url cache problem
        url1 = url1 + '&dummy=' + new Date().getTime();
    } else {
        var p = new Poly9.URLParser(url1);
        dataSend = p.getQuerystring();
    }
    req.open(m, url1, true);
    req.onreadystatechange = processInitialRequest;
    if (m == 'POST') {
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    }
    req.send(dataSend);
}

/**
 * - processInitialRequest -
 *
 * Callback function for initial request to schedule a task.
 * Server script will return XML code like this:
 *
 *  &lt;?xml version="1.0" encoding="iso-8859-1"?&gt;
 *  &lt;progress id="PB1" taskId="375" /&gt;
 *
 * where "id" is the progress bar identifier; see HTML_Progress2::getIdent()
 * and "taskId" is the negociated task identifier.
 *
 * @return     void
 * @public
 * @since      2.3.0a1
 */
function processInitialRequest()
{
    if (req.readyState == 4) {
        if (req.status == 200) {
            var message = req.responseXML.getElementsByTagName("progress")[0];
            progressId = message.getAttribute("id");
            taskId = message.getAttribute("taskId");
        }
        // do the initial poll in 2 seconds (default timeout)
        setTimeout("pollTaskmaster()", timeout);
    }
}

/**
 * - pollTaskmaster -
 *
 * proceed polling loop until server side operation is completed (a response of 100 is returned)
 *
 * @return     void
 * @public
 * @since      2.3.0a1
 */
function pollTaskmaster()
{
    var m = reqMethod.toUpperCase();
    var dataSend = null;

    url2 = url2 + escape(taskId);

    if (m == 'GET') {
        // avoid browser url cache problem
        url2 = url2 + '&dummy=' + new Date().getTime();
    } else {
        var p = new Poly9.URLParser(url2);
        dataSend = p.getQuerystring();
    }
    req.open(m, url2, true);
    req.onreadystatechange = processPollRequest;
    if (m == 'POST') {
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    }
    req.send(dataSend);
}

/**
 * - processPollRequest -
 *
 * Callback function for polling loop request to handle a scheduled task.
 * Server script will return XML code like this:
 *
 * &lt;code&gt;
 *  &lt;?xml version="1.0" encoding="iso-8859-1"?&gt;
 *  &lt;progress id="PB1" taskId="375"&gt;
 *   &lt;percentage&gt;12&lt;/percentage&gt;
 * &lt;/code&gt;
 *
 * @return     void
 * @public
 * @since      2.3.0a1
 */
function processPollRequest()
{
    if (req.readyState == 4) {
        if (req.status == 200) {
            var message = req.responseXML.getElementsByTagName('progress')[0];
            var percent = message.getElementsByTagName('percentage')[0];
            var percentage = percent.firstChild.nodeValue;
            var cell = Math.floor(percentage / 10);

           setProgress(progressId, cell, 0);
           setLabelText(progressId, 'pct1', percentage + "%")
        }
        // continue on other poll in 2 seconds (default timeout)
        if (percentage < 100) {
            setTimeout("pollTaskmaster()", timeout);
        } else {
            setTimeout("complete()", timeout);
        }
    }
}

