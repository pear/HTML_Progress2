<?php
/**
 * Basic error renderer with default PEAR_Error object.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

require_once 'HTML/Progress2.php';
require_once 'PEAR.php';

// Example A. ---------------------------------------------

// A1. Exception
$pb1 = new HTML_Progress2(null, HTML_PROGRESS2_BAR_VERTICAL, '0', 130);

print 'still alive !';

?>