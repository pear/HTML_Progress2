<?php
/**
 * Ajax driver base class.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   HTML
 * @package    HTML_Progress2
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2007 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/HTML_Progress2
 * @since      File available since Release 2.3.0a1
 */

/**
 * Ajax driver base class.
 *
 * Provide common methods of all AJAX driver class.
 *
 * Here is a basic example:
 * <code>
 * <?php
 * require_once 'HTML/Progress2.php';
 *
 * $pb = new HTML_Progress2();
 * // try to register the standard DOM XML Ajax driver
 * $ae = $pb->registerAjax();
 * if ($ae) {
 *   $ae->setRequestUri(basename(__FILE__));
 *   $ae->setRequestMethod('post');
 *   $ae->setRequestTimeout(2500);
 *   $ae->setUrlArguments('startTask', 'targetId');
 * }
 * ?>
 * </code>
 *
 * @category   HTML
 * @package    HTML_Progress2
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2007 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/HTML_Progress2
 * @since      Class available since Release 2.3.0a1
 */

class HTML_Progress2_Ajax_Common
{
    /**
     * The progress2 object.
     *
     * @var        object
     * @since      2.3.0a1
     * @access     private
     */
    var $_progress;

    /**
     * Server script URL that handle Ajax client tasks.
     *
     * @var        string
     * @since      2.3.0a1
     * @access     public
     */
    var $url;

    /**
     * Http request mode (GET or POST).
     *
     * @var        string
     * @since      2.3.0a1
     * @access     public
     */
    var $method;

    /**
     * Delay in millisecond between each new polling loop starts.
     *
     * @var        string
     * @since      2.3.0a1
     * @access     public
     */
    var $timeout;

    /**
     * Arguments to negotiate a new task identifier and passing though
     * the server on polling loop.
     *
     * @var        array
     * @since      2.3.0a1
     * @access     public
     */
    var $url_args;

    /**
     * Constructor (ZE2) Summary
     *
     * Creates an Ajax progress-meter basic driver
     *
     * @param      object    $obj           reference to a progress2 object
     *
     * @since      2.3.0a1
     * @access     protected
     * @see        setRequestUri(), setRequestMethod(), setRequestTimeout()
     */
    function __construct(&$obj)
    {
        $this->_progress = $obj;
        $this->method = 'get';
        $this->timeout = 2000;
        $this->url_args = array('registerTask', 'TaskId');
    }

    /**
     * set URL to handle Ajax requests.
     *
     * Defines the server script URL that will handle Ajax client requests.
     *
     * @param      string    $url           Server script URL
     *
     * @since      2.3.0a1
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     */
    function setRequestUri($url)
    {
        if (!is_string($url)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$url',
                      'was' => gettype($url),
                      'expected' => 'string',
                      'paramnum' => 1));
        }
        $this->url = $url;
    }

    /**
     * set HTTP Ajax requests method.
     *
     * Defines the request method to send Ajax client data to remote server.
     *
     * @param      string    $type          (optional) method to send data (GET or POST)
     *                                      Default value is GET.
     *
     * @since      2.3.0a1
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     */
    function setRequestMethod($type = 'GET')
    {
        if (!is_string($type)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$type',
                      'was' => gettype($type),
                      'expected' => 'string',
                      'paramnum' => 1));

        } elseif (!in_array(strtoupper($type), array('GET', 'POST'))) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'error',
                array('var' => '$type',
                      'was' => $type,
                      'expected' => 'GET | POST',
                      'paramnum' => 1));
        }
        $this->method = $type;
    }

    /**
     * set timeout between each polling loop.
     *
     * Defines the time to wait before requesting new fresh data from remote server
     *
     * @param      int       $delay         (optional) delay should be positive
     *                                      and greater than 1000 (to avoid server overload)
     *                                      Default value is 2000 (2 seconds).
     *
     * @since      2.3.0a1
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     */
    function setRequestTimeout($delay = 2000)
    {
        if (!is_int($delay)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$delay',
                      'was' => gettype($delay),
                      'expected' => 'integer',
                      'paramnum' => 1));

        } elseif ($delay < 0) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'error',
                array('var' => '$delay',
                      'was' => $delay,
                      'expected' => 'greater than zero',
                      'paramnum' => 1));
        }
        $this->timeout = $delay;
    }

    /**
     * set action arguments to handle task id.
     *
     * Defines url mapped action to handle task id.
     *
     * @param      string    $action1       (optional) argument name to handle action of task id creation
     *                                      Default value is 'createTaskId'
     * @param      string    $action2       (optional) argument name to handle identify of task id
     *                                      Default value is 'TaskId'
     *
     * @since      2.3.0a1
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     */
    function setUrlArguments($action1 = 'registerTask', $action2 = 'TaskId')
    {
        if (!is_string($action1) || empty($action1)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$action1',
                      'was' => empty($action1) ? $action1 : gettype($action1),
                      'expected' => 'no empty string',
                      'paramnum' => 1));

        } elseif (!is_string($action2) || empty($action2)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$action2',
                      'was' => empty($action2) ? $action2 : gettype($action2),
                      'expected' => 'no empty string',
                      'paramnum' => 2));
        }
        $this->url_args = array($action1, $action2);
    }

    /**
     * Returns javascript progress meter handler.
     *
     * Ajax code to handle the progress meter polling sequence.
     *
     * @param      boolean   $raw           html output with script tags or just raw data
     *
     * @return     string
     * @since      2.3.0a1
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_ABSTRACT
     * @see        HTML_Progress2::getScript()
     * @abstract
     */
    function getScript($raw)
    {
        return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_ABSTRACT, 'exception',
            array('method' => __CLASS__ .'::'.__FUNCTION__));
    }
}
?>