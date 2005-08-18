<?php
/**
 * The HTML_Progress2_Monitor class allow an easy way to display progress
 * in a dialog box. The user-end can cancel the task.
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

require_once 'HTML/Progress2.php';
require_once 'HTML/QuickForm.php';

/**
 * The HTML_Progress2_Monitor class allow an easy way to display progress
 * in a dialog box. The user-end can cancel the task.
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

class HTML_Progress2_Monitor
{
    /**
     * Instance-specific unique identification number.
     *
     * @var        integer
     * @since      2.0.0
     * @access     private
     */
    var $_id;

    /**#@+
     * Attributes of monitor form.
     *
     * @var        string
     * @since      2.0.0
     * @access     public
     */
    var $windowname;
    var $buttonStart;
    var $buttonCancel;
    var $autorun;
    /**#@-*/

    /**
     * Monitor status (text label of progress bar).
     *
     * @var        array
     * @since      2.0.0
     * @access     public
     */
    var $caption = array();

    /**
     * The progress object renders into this monitor.
     *
     * @var        object
     * @since      2.0.0
     * @access     private
     */
    var $_progress;

    /**
     * The quickform object that allows the presentation.
     *
     * @var        object
     * @since      2.0.0
     * @access     private
     */
    var $_form;

    /**
     * Stores the event dispatcher which handles notifications
     *
     * @var        array
     * @since      2.0.0RC2
     * @access     protected
     */
    var $dispatcher;

    /**
     * Count the number of observer registered.
     * The Event_Dispatcher will be add on first observer registration, and
     * will be removed with the last observer.
     *
     * @var        integer
     * @since      2.0.0RC2
     * @access     private
     */
    var $_observerCount;


    /**
     * Constructor (ZE1)
     *
     * @since      2.0.0
     * @access     public
     */
    function HTML_Progress2_Monitor($formName = 'ProgressMonitor', $attributes = array(),
                                    $errorPrefs = array())
    {
        $this->__construct($formName, $attributes, $errorPrefs);
    }

    /**
     * Constructor (ZE2) Summary
     *
     * o Creates a standard progress bar into a dialog box (QuickForm).
     *   Form name, buttons 'start', 'cancel' labels and style, and
     *   title of dialog box may also be changed.
     *   <code>
     *   $monitor = new HTML_Progress2_Monitor();
     *   </code>
     *
     * o Creates a progress bar into a dialog box, with only a new
     *   form name.
     *   <code>
     *   $monitor = new HTML_Progress2_Monitor($formName);
     *   </code>
     *
     * o Creates a progress bar into a dialog box, with a new form name,
     *   new buttons name and style, and also a different title box.
     *   <code>
     *   $monitor = new HTML_Progress2_Monitor($formName, $attributes);
     *   </code>
     *
     * @param      string    $formName      (optional) Name of monitor dialog box (QuickForm)
     * @param      array     $attributes    (optional) List of renderer options
     * @param      array     $errorPrefs    (optional) Hash of params to configure error handler
     *
     * @since      2.0.0
     * @access     protected
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     */
    function __construct($formName = 'ProgressMonitor', $attributes = array(),
                         $errorPrefs = array())
    {
        $this->_progress = new HTML_Progress2($errorPrefs);

        if (!is_string($formName)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$formName',
                      'was' => gettype($formName),
                      'expected' => 'string',
                      'paramnum' => 1));

        } elseif (!is_array($attributes)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$attributes',
                      'was' => gettype($attributes),
                      'expected' => 'array',
                      'paramnum' => 2));

        }

        $this->_id = md5(microtime());
        $this->_observerCount = 0;

        $this->_form = new HTML_QuickForm($formName);
        $this->_form->removeAttribute('name');        // XHTML compliance

        $captionAttr = array('id' => 'monitorStatus', 'valign' => 'bottom', 'left' => 0);

        $this->windowname   = isset($attributes['title'])  ? $attributes['title']  : 'In progress ...';
        $this->buttonStart  = isset($attributes['start'])  ? $attributes['start']  : 'Start';
        $this->buttonCancel = isset($attributes['cancel']) ? $attributes['cancel'] : 'Cancel';
        $buttonAttr         = isset($attributes['button']) ? $attributes['button'] : '';
        $this->autorun      = isset($attributes['autorun'])? $attributes['autorun']: false;
        $this->caption      = isset($attributes['caption'])? $attributes['caption']: $captionAttr;

        $this->_progress->addLabel(HTML_PROGRESS2_LABEL_TEXT, $this->caption['id']);
        $captionAttr = $this->caption;
        unset($captionAttr['id']);
        $this->_progress->setLabelAttributes($this->caption['id'], $captionAttr);
        $this->_progress->setProgressAttributes('top=0 left=0');

        $this->_form->addElement('header', 'windowname', $this->windowname);
        $this->_form->addElement('static', 'progressBar');

        if ($this->isStarted() && !$this->isCanceled()) {
            $style = array('disabled'=>'true');
        } else {
            $style = null;
        }

        $buttons[] =& $this->_form->createElement('submit', 'start',  $this->buttonStart, $style);
        $buttons[] =& $this->_form->createElement('submit', 'cancel', $this->buttonCancel);

        $buttons[0]->updateAttributes($buttonAttr);
        $buttons[1]->updateAttributes($buttonAttr);

        $this->_form->addGroup($buttons, 'buttons', '', '&nbsp;', false);

        // default embedded progress element with look-and-feel
        $this->setProgressElement($this->_progress);
    }

    /**
     * Adds a new observer to the Event Dispatcher that will listen
     * for all messages emitted by this HTML_Progress2 instance.
     *
     * @param      mixed     $callback      PHP callback that will act as listener
     *
     * @return     void
     * @since      2.0.0
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_CALLBACK
     * @see        removeListener()
     */
    function addListener($callback)
    {
        if (!is_callable($callback)) {
            return $this->raiseError(HTML_PROGRESS2_ERROR_INVALID_CALLBACK, 'exception',
                array('var' => '$callback',
                      'element' => 'valid Class-Method/Function',
                      'was' => 'callback',
                      'paramnum' => 1));
        }

        $this->dispatcher =& Event_Dispatcher::getInstance();
        $this->dispatcher->addObserver($callback);
        $this->_observerCount++;
    }

    /**
     * Removes a registered observer.
     *
     * @param      mixed     $callback      PHP callback that act as listener
     *
     * @return     bool                     True if observer was removed, false otherwise
     * @since      2.0.0
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_CALLBACK
     * @see        addListener()
     */
    function removeListener($callback)
    {
        if (!is_callable($callback)) {
            return $this->raiseError(HTML_PROGRESS2_ERROR_INVALID_CALLBACK, 'exception',
                array('var' => '$callback',
                      'element' => 'valid Class-Method/Function',
                      'was' => 'callback',
                      'paramnum' => 1));
        }

        $result = $this->dispatcher->removeObserver($callback);

        if ($result) {
            $this->_observerCount--;
            if ($this->_observerCount == 0) {
                unsset($this->dispatcher);
            }
        }
        return $result;
    }

    /**
     * Returns TRUE if progress was started by user, FALSE otherwise.
     *
     * @return     bool
     * @since      2.0.0
     * @access     public
     */
    function isStarted()
    {
        $action = $this->_form->getSubmitValues();
        return (isset($action['start']) || $this->autorun);
    }

    /**
     * Returns TRUE if progress was canceled by user, FALSE otherwise.
     *
     * @return     bool
     * @since      2.0.0
     * @access     public
     */
    function isCanceled()
    {
        $action = $this->_form->getSubmitValues();
        $canceled = isset($action['cancel']);
        if ($canceled) {
            $this->_postNotification('onCancel');
        }
        return $canceled;
    }

    /**
     * Display Monitor and catch user action (cancel button).
     *
     * @return     void
     * @since      2.0.0
     * @access     public
     */
    function run()
    {
        if ($this->isStarted() && !$this->isCanceled()) {
            $this->_progress->_status = 'show';

            $this->_postNotification('onSubmit');
            $this->_progress->run();
            $this->_postNotification('onLoad');
        }
    }

    /**
     * Attach a progress bar to this monitor.
     *
     * @param      object    $bar           a html_progress2 instance
     *
     * @return     void
     * @since      2.0.0
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     * @see        getProgressElement()
     */
    function setProgressElement(&$bar)
    {
        if (!is_a($bar, 'HTML_Progress2')) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$bar',
                      'was' => gettype($bar),
                      'expected' => 'HTML_Progress2 object',
                      'paramnum' => 1));
        }
        $this->_progress = $bar;

        $bar =& $this->_form->getElement('progressBar');
        $bar->setText( $this->_progress->toHtml() );
    }

    /**
     * Returns a reference to the progress bar object
     * used with the monitor.
     *
     * @return     object
     * @since      2.0.0
     * @access     public
     * @see        setProgressElement()
     */
    function &getProgressElement()
    {
        return $this->_progress;
    }

    /**
     * Returns progress styles (StyleSheet).
     *
     * @param      boolean   (optional) html output with script tags or just raw data
     *
     * @return     string
     * @since      2.0.0
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     */
    function getStyle($raw = true)
    {
        if (!is_bool($raw)) {
            return $this->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$raw',
                      'was' => gettype($raw),
                      'expected' => 'boolean',
                      'paramnum' => 1));
        }

        return $this->_progress->getStyle($raw);
    }

    /**
     * Returns the javascript URL or inline code to manage progress bar.
     *
     * @param      boolean   (optional) html output with script tags or just raw data
     *
     * @return     string
     * @since      2.0.0
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     * @access     public
     */
    function getScript($raw = true)
    {
        if (!is_bool($raw)) {
            return $this->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$raw',
                      'was' => gettype($raw),
                      'expected' => 'boolean',
                      'paramnum' => 1));
        }

        return $this->_progress->getScript($raw);
    }

    /**
     * Returns Monitor forms as a Html string.
     *
     * @return     string
     * @since      2.0.0
     * @access     public
     */
    function toHtml()
    {
        $barAttr = $this->_progress->getProgressAttributes();
        $width = $barAttr['width'] + 70;

        $formTpl = "\n<form{attributes}>"
                 . "\n<div>"
                 . "\n{hidden}"
                 . "<table width=\"{$width}\" border=\"0\">"
                 . "\n{content}"
                 . "\n</table>"
                 . "\n</div>"
                 . "\n</form>";
        $renderer =& $this->_form->defaultRenderer();
        $renderer->setFormTemplate($formTpl);

        return $this->_form->toHtml();
    }

    /**
     *
     *
     * @return     void
     * @since      2.0.0RC2
     * @access     public
     */
    function display()
    {
        echo $this->toHtml();
    }

    /**
     * Accepts a renderer
     *
     * @param      object    $renderer      An HTML_QuickForm_Renderer object
     *
     * @return     void
     * @since      2.0.0
     * @access     public
     */
    function accept(&$renderer)
    {
        if (!is_a($renderer, 'HTML_QuickForm_Renderer')) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$renderer',
                      'was' => gettype($renderer),
                      'expected' => 'HTML_QuickForm_Renderer object',
                      'paramnum' => 1));
        }
        $this->_form->accept($renderer);
    }

    /**
     * Display a caption on action in progress.
     *
     * The idea of a simple utility function for replacing variables
     * with values in an message template, come from sprintfErrorMessage
     * function of Error_Raise package by Greg Beaver.
     *
     * This simple str_replace-based function can be used to have an
     * order-independent sprintf, so messages can be passed in
     * with different grammar ordering, or other possibilities without
     * changing the source code.
     *
     * Variables should simply be surrounded by % as in %varname%
     *
     * @param      string    $caption       (optional) message template
     * @param      array     $args          (optional) associative array of
     *                                      template var -> message text
     * @since      2.0.0
     * @access     public
     */
    function setCaption($caption = '&nbsp;', $args = array())
    {
        if (!is_string($caption)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$caption',
                      'was' => gettype($caption),
                      'expected' => 'string',
                      'paramnum' => 1));

        } elseif (!is_array($args)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$args',
                      'was' => gettype($args),
                      'expected' => 'array',
                      'paramnum' => 2));
        }

        foreach($args as $name => $value) {
            $caption = str_replace("%$name%", $value, $caption);
        }
        $this->_progress->setLabelAttributes($this->caption['id'], array('value' => $caption));
    }

    /**
     * Post a new notification to all observers registered.
     * This notification occured only if a dispatcher exists. That means if
     * at least one observer was registered.
     *
     * @param      string    $event         Name of the notification handler
     * @param      array     $info          (optional) Additional information about the notification
     *
     * @return     void
     * @since      2.0.0RC2
     * @access     private
     */
    function _postNotification($event, $info = array())
    {
        if (isset($this->dispatcher)) {
            $info['sender'] = get_class($this);
            $info['time']   = microtime();
            $this->dispatcher->post($this, $event, $info);
        }
    }
}
?>