<?php
/**
 * HTML_Progress2_Generator with a grey-orange skin
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/generator/generatorcus2.php
 *             generatorcus2 source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/generatorcus2.png
 *             screenshot (Image PNG, 768x414 pixels) 38.2 Kb
 */

require_once 'HTML/Progress2/Generator.php';

session_start();

$tabbed =& HTML_Progress2_Generator::singleton('PBwizard');

// add ability to dump some informations for debugging
$tabbed->addActions(array('dump' => 'ActionDump'));

// add default renderer but with a custom stylesheet
$css = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'generator.css';
$tabbed->addAction('display', new ActionDisplay($css));

$tabbed->run();
?>