<?php
/**
 * The HTML_Progress2_Observer implements the observer pattern
 * for watching progress bar activity and taking actions
 * on exceptional events.
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
 * The HTML_Progress2_Observer implements the observer pattern
 * for watching progress bar activity and taking actions
 * on exceptional events.
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

class HTML_Progress2_Observer
{
    /**
     * Instance-specific unique identification number.
     *
     * @var        integer
     * @since      2.0.0
     * @access     private
     */
    var $_id;

    /**
     * Creates a new basic HTML_Progress2_Observer instance.
     *
     * @since      2.0.0
     * @access     public
     */
    function HTML_Progress2_Observer()
    {
        $this->_id = md5(microtime());
    }

    /**
     * This is a stub method to make sure that HTML_Progress2_Observer classes do
     * something when they are notified of a message.  The default behavior
     * is to just write into a file 'progress_observer.log' in current directory.
     * You should override this method.
     *
     * Default events :
     * - setMinimum
     * - setMaximum
     * - setValue
     *
     * @param      mixed     $event         A hash describing the progress event.
     * @since      2.0.0
     * @access     public
     */
    function notify($event)
    {
        $msg = (is_array($event)) ? serialize($event) : $event;
        error_log ("$msg \n", 3, 'progress_observer.log');
    }
}
?>
