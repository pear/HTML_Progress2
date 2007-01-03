<?php
/**
 * HTML_Progress2 Package Script Generator
 *
 * Generate a new fresh version of package xml 2.0 built with PEAR_PackageFileManager 1.6.0+
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
 * @copyright  2006 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/HTML_Progress2
 * @since      File available since Release 2.1.1
 * @ignore
 */

require_once 'PEAR/PackageFileManager2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$packagefile = 'c:/php/pear/HTML_Progress2/package2.xml';

$options = array('filelistgenerator' => 'cvs',
    'packagefile' => 'package2.xml',
    'baseinstalldir' => 'HTML',
    'simpleoutput' => true,
    'clearcontents' => false,
    'changelogoldtonew' => false,
    'ignore' => array('package.php')
    );

$p2 = &PEAR_PackageFileManager2::importOptions($packagefile, $options);
$p2->setPackageType('php');
$p2->addRelease();
$p2->generateContents();
$p2->setReleaseVersion('2.2.0');
$p2->setAPIVersion('2.2.0');
$p2->setReleaseStability('stable');
$p2->setAPIStability('stable');
$p2->setNotes('* news
- add new function importStyle() to give ability to import an existing stylesheet
and separate PHP code from HTML layout (with CSS)

* changes
- improved javascript custom handler for JavaDanse example related to version 2.1.1 (bug fixed #8684)

* QA
- include a new revision of User Guide (TDG) that cover all versions 2.x.x
  see http://pear.laurent-laville.org/HTML_Progress2 for more format to download.
');
$p2->addPackageDepWithChannel('required', 'HTML_CSS', 'pear.php.net', '1.1.2');

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $p2->writePackageFile();
} else {
    $p2->debugPackageFile();
}
?>