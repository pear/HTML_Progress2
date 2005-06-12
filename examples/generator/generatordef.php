<?php
/**
 * Generator example using Default QF renderer
 * without any changes (all default options are used).
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2 
 * @subpackage Examples
 * @access     public
 */
require_once 'HTML/Progress2/Generator.php';

session_start();

$tabbed = new HTML_Progress2_Generator();
$tabbed->run();
?>