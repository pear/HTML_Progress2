<?php
/**
 * HTML_Progress2 Package Script Generator
 *
 * Generate a new fresh version of package xml 2.0
 * built with PEAR_PackageFileManager 1.6.0+
 *
 * PHP versions 4 and 5
 *
 * @category  HTML
 * @package   HTML_Progress2
 * @author    Laurent Laville <pear@laurent-laville.org>
 * @copyright 2006-2008 Laurent Laville
 * @license   http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/HTML_Progress2
 * @since     File available since Release 2.1.1
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
    'ignore' => array('package.php', 'CVS/', 'Thumbs.db', 'callouts/'),
    'exceptions' => array(
        'ChangeLog' => 'doc',
        'NEWS' => 'doc',
        'HOWTO_AJAX.txt' => 'doc')
    );

$p2 = &PEAR_PackageFileManager2::importOptions($packagefile, $options);
$p2->setPackageType('php');
$p2->addRelease();
$p2->generateContents();
$p2->setReleaseVersion('2.4.0');
$p2->setAPIVersion('2.4.0');
$p2->setReleaseStability('stable');
$p2->setAPIStability('stable');
$p2->setNotes('* news
- implement request #12532 : Add addional info to apc5 info

* changes
- drop support of UPM4 backend in HTML_Progress2_Upload (PHP4 patch for upload)

* bugs
- #13664 : setLabelAttributes does not work

* QA
- fix lot of CS, following recommandation of PHP_CodeSniffer 1.0.1
- fix PHP minimum requirement (4.3.10)
- require now at least PEAR installer 1.5.4 rather than 1.3.4
(security vulnerability fixes)
');

//$p2->setLicense('BSD', 'http://www.opensource.org/licenses/bsd-license.php');
//$p2->addMaintainer('contributor', 'arpad', 'Arpad Ray', 'arpad@php.net');
//$p2->addPackageDepWithChannel('optional', 'HTML_AJAX', 'pear.php.net', '0.5.0');
//$p2->setExtends('HTML_Progress');
//$p2->setPhpDep('4.3.0');

if (isset($_GET['make'])
    || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $p2->writePackageFile();
} else {
    $p2->debugPackageFile();
}
?>