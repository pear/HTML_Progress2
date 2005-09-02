<?php
/**
 * Release Notes for HTML_Progress2 package.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @ignore
 */

// New version and state of the package
$release['version'] = '2.0.0';
$release['state']   = 'stable';

// Notes about this new release
$release['notes'] = <<<NOTES
* news (HTML_Progress_Lite)
- add font-style attribute for all label categories
(ability to use italic for percent and text labels)

* bugs
- Fixed my first bug in HTML_Progress2_Lite::setLabelAttributes() method
related to font group attributes.
- Fixed bug in moveNext() method: avoid exceed max limit

* Quality Assurance
The Definitive (User) Guide:
- include a complete english guide for both beginners and expert users.
  This is the many html files version. Others format are
  available to download at URI http://pear.laurent-laville.org/HTML_Progress2/docs
More W3C/CSS standard compliance with HTML_Progress_Lite class:
- background-color attribute has transparent rather than null string by default
- frame attribute border renamed to border-width
API documentation generation:
- added @example tag to have ability to display (highlight) source code
- added @link tag to have ability to display a screenshot (PNG image)
- removed all @tutorial tag
- added @ignore tag on all unit testcases and some others files
to avoid includes in API docs


Live demos, screenshots, source codes and much more are available on my
project homepage at http://pear.laurent-laville.org/HTML_Progress2
NOTES;

// specify files to exclude entirely from the package.xml
$release['ignore'] = array(
    'package.xml', 'packageV1.php', basename(__FILE__),
    'cache/',
    'Thumbs.db'
);

// specify file role for specific files
$release['exceptions'] = array(
    'ChangeLog' => 'doc',
    'NEWS' => 'doc'
);

// specify directory roles
$release['dir_roles'] = array(
    // standard
    'docs' => 'doc',
    'examples' => 'doc',
    'tests' => 'test',
    // additional
    'Progress2' => 'php'
);

// List of replacements that should be performed on every single file
// if list is empty then a global replacement will be apply
$release['replacements'] = array();  // none replacement
$release['replacements'] = true;     // global replacement
$release['replacements'] = array(    // replacement on a subset of files
    'Progress2.php',
    'Progress2_Lite.php',
    'Progress2/Error.php',
    'Progress2/Monitor.php',
    'Progress2/Observer.php',
    'Progress2/Generator.php',
    'Progress2/Generator/Default.php',
    'Progress2/Generator/HTMLPage2.php',
    'Progress2/Generator/ITDynamic.php',
    'Progress2/Generator/pages.php',
    'Progress2/Generator/Preview.php',
    'Progress2/Generator/Process.php',
    'Progress2/Generator/SmartyDynamic.php'
);

// specify Maintainers list
$release['maintainers'] = array(
    'farell' => array('role' => 'lead', 'name' => 'Laurent Laville', 'email' => 'pear@laurent-laville.org')
);

// specify Dependencies list
$release['dependencies'] = false;     // no dependency
$release['dependencies'] = array();   // no dependency (empty list)
$release['dependencies'] = array(
    'PHP'  => array('version' => '4.2.0', 'type' => 'php'),
    'PHP_Compat'  => array('version' => '1.4.1'),
    'HTML_Common'  => array('version' => '1.2.1'),
    'Event_Dispatcher'  => array('version' => '0.9.1'),
    'PEAR'  => array('version' => '1.3.5', 'optional' => true),
    'HTML_QuickForm'  => array('version' => '3.2.4', 'operator' => 'gt', 'optional' => true),
    'HTML_QuickForm_Controller'  => array('version' => '1.0.4', 'optional' => true),
    'Image_Color'  => array('version' => '1.0.1', 'optional' => true),
    'HTML_Page2'  => array('version' => '0.5.0', 'optional' => true),
    'HTML_Template_IT'  => array('version' => '1.1', 'optional' => true),
    'HTML_Template_Sigma'  => array('version' => '1.1.2', 'optional' => true),
    'Log'  => array('version' => '1.8.7', 'optional' => true),
    'gd'  => array('operator' => 'has', 'type' => 'ext', 'optional' => true)
);

?>