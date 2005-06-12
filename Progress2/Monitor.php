<?php
/**
 * The HTML_Progress2_Monitor class allow an easy way to display progress
 * in a dialog. The user can cancel the task.
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
 * in a dialog. The user can cancel the task.
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
 * @tutorial   HTML_Progress2_Monitor.pkg
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
     * Callback, either function name or array(&$object, 'method')
     *
     * @var        mixed
     * @since      2.0.0
     * @access     private
     * @see        setProgressHandler()
     */
    var $_callback = null;

    
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

        $this->_form = new HTML_QuickForm($formName);

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
     * Listens all progress events from this monitor.
     *
     * @param      mixed     $event         A hash describing the progress event.
     *
     * @return     void
     * @since      2.0.0
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     * @see        HTML_Progress2::process()
     * @tutorial   monitor.notify.pkg
     */
    function notify($event)
    {
        if (!is_array($event)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$event',
                      'was' => gettype($event),
                      'expected' => 'array',
                      'paramnum' => 1));
        }
        if (strcasecmp($event['log'], 'moveStep') == 0) {
            if (is_null($this->_callback)) {
                $this->_progress->sleep();
            } else {
                call_user_func($this->_callback, $event['value'], $this);
            }
                 
            if ($this->_progress->getPercentComplete() == 1) {
                if ($this->_progress->isIndeterminate()) {
                    $this->_progress->setValue(0);
                } else {
                    // the progress bar has reached 100%
                    $this->_progress->removeListener($this);
                }
            } else {
                $this->_progress->moveNext();
            }
        }
    }

    /**
     * Sets a user-defined progress handler function.
     *
     * @param      mixed     $handler       Name of function or a class-method.
     *
     * @return     void
     * @since      2.0.0
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_CALLBACK
     * @tutorial   monitor.setprogresshandler.pkg
     */
    function setProgressHandler($handler)
    {
        if (!is_callable($handler)) {
            return $this->raiseError(HTML_PROGRESS2_ERROR_INVALID_CALLBACK, 'warning',
                array('var' => '$handler',
                      'element' => 'valid Class-Method/Function',
                      'was' => 'element',
                      'paramnum' => 1));
        }
        $this->_callback = $handler;

        // reflect changes on the observer copy
        $this->_progress->addListener($this);
    }

    /**
     * Returns TRUE if progress was started by user, FALSE otherwise.
     *
     * @return     bool
     * @since      2.0.0
     * @access     public
     * @tutorial   monitor.isstarted.pkg
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
     * @tutorial   monitor.iscanceled.pkg
     */
    function isCanceled()
    {
        $action = $this->_form->getSubmitValues();
        return isset($action['cancel']);
    }

    /**
     * Display Monitor and catch user action (cancel button).
     *
     * @return     void
     * @since      2.0.0
     * @access     public
     * @tutorial   monitor.run.pkg
     */
    function run()
    {
        if ($this->isStarted() && !$this->isCanceled()) {
            $this->_progress->_status = 'show';
            $this->_progress->moveNext();
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
     * @tutorial   monitor.setprogresselement.pkg
     */
    function setProgressElement($bar)
    {
        if (!is_a($bar, 'HTML_Progress2')) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$bar',
                      'was' => gettype($bar),
                      'expected' => 'HTML_Progress2 object',
                      'paramnum' => 1));
        }
        $this->_progress = $bar;
        $this->_progress->addListener($this);

        $barAttr = $bar->getProgressAttributes();
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
     * @tutorial   monitor.getprogresselement.pkg
     */
    function &getProgressElement()
    {
        return $this->_progress;
    }

    /**
     * Returns progress styles (StyleSheet).
     *
     * @return     string
     * @since      2.0.0
     * @access     public
     * @tutorial   monitor.getstyle.pkg
     */
    function getStyle()
    {
        return $this->_progress->getStyle();
    }

    /**
     * Returns progress javascript.
     *
     * @return     string
     * @since      2.0.0
     * @access     public
     * @tutorial   monitor.getscript.pkg
     */
    function getScript()
    {
        return $this->_progress->getScript();
    }

    /**
     * Returns Monitor forms as a Html string.
     *
     * @return     string
     * @since      2.0.0
     * @access     public
     * @tutorial   monitor.tohtml.pkg
     */
    function toHtml()
    {
        return $this->_form->toHtml();
    }

    /**
     * Accepts a renderer
     *
     * @param      object    $renderer      An HTML_QuickForm_Renderer object
     *
     * @return     void
     * @since      2.0.0
     * @access     public
     * @tutorial   monitor.accept.pkg
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
     * @tutorial   monitor.setcaption.pkg
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
        $this->_progress->setLabelAttributes($this->caption['id'], 
            array('value' => $caption)
            );
    }
}
?>