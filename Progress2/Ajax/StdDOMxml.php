<?php
/**
 * Ajax standard DOM XML driver class.
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

require_once 'HTML/Progress2/Ajax/Common.php';

/**
 * Ajax standard DOM XML driver class.
 *
 * Provide handler of standard DOM XML usage. Available on all browsers Ajax compliant.
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
 *   $ae->setRequestUri();
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

class HTML_Progress2_Ajax_StdDOMxml extends HTML_Progress2_Ajax_Common
{
    /**
     * Constructor (ZE1)
     *
     * Creates an Ajax progress-meter default driver
     *
     * @param      object    $obj           reference to a progress2 object
     *
     * @since      2.3.0a1
     * @access     public
     * @see        HTML_Progress2_Ajax_Common::setRequestUri(),
     *             HTML_Progress2_Ajax_Common::setRequestMethod(),
     *             HTML_Progress2_Ajax_Common::setRequestTimeout()
     */
    function HTML_Progress2_Ajax_StdDOMxml(&$obj)
    {
        $this->__construct($obj);
    }

    /**
     * Constructor (ZE2) Summary
     *
     * Creates an Ajax progress-meter default driver
     *
     * @param      object    $obj           reference to a progress2 object
     *
     * @since      2.3.0a1
     * @access     protected
     * @see        HTML_Progress2_Ajax_Common::setRequestUri(),
     *             HTML_Progress2_Ajax_Common::setRequestMethod(),
     *             HTML_Progress2_Ajax_Common::setRequestTimeout()
     */
    function __construct(&$obj)
    {
        parent::__construct($obj);
    }

    /**
     * Returns javascript progress meter handler.
     *
     * Ajax code to handle the progress meter polling sequence.
     *
     * @param      boolean   $raw           (optional) html output with script tags or just raw data
     *
     * @return     string
     * @since      2.3.0a1
     * @access     public
     * @throws     HTML_PROGRESS2_ERROR_INVALID_INPUT
     * @see        HTML_Progress2::getScript()
     */
    function getScript($raw = true)
    {
        if (!is_bool($raw)) {
            return $this->_progress->raiseError(HTML_PROGRESS2_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$raw',
                      'was' => gettype($raw),
                      'expected' => 'boolean',
                      'paramnum' => 1));
        }

        $js = '@data_dir@' . DIRECTORY_SEPARATOR
            . '@package_name@' . DIRECTORY_SEPARATOR
            . 'progress2AjaxHandler.js';

        if (file_exists($js)) {
            $js = file_get_contents($js);
        } else {
            $js = '';
        }

        if ($raw !== true) {
            $js = '<script type="text/javascript">'
                . PHP_EOL . '//<![CDATA['
                . PHP_EOL . $js
                . PHP_EOL . '//]]>'
                . PHP_EOL . '</script>'
                . PHP_EOL;
        }
        return $js;
    }
}
?>