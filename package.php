<?php
/**
 * Make the package.xml 1.0 and 2.0 versions
 * with PEAR_PackageFileManager_Frontend_Web.
 *
 * @category   HTML
 * @package    HTML_Progress2
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2005-2006 Laurent Laville
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id$
 * @since      File available since Release 2.0.1
 */

require_once 'PEAR/PackageFileManager/Frontend.php';

session_start();

// where to find package sources
$pkgDir = 'c:/php/pear/HTML_Progress2/package2.xml';

$web =& PEAR_PackageFileManager_Frontend::singleton('Web', $pkgDir);
// configuration options
$web->setOption('baseinstalldir', 'HTML');
$web->setOption('exportcompatiblev1', true);
$web->setOption('changelogoldtonew', false);
$web->setOption('simpleoutput', true);
$web->setOption('outputdirectory', 'c:/php/pear');
$web->setOption('filelistgenerator', 'cvs');

// stop if serious error(s)
if ($web->hasErrors('error')) {
    $errors = $web->getErrors();
    echo '<pre>';
    var_dump($errors);
    echo '</pre>';
    die('exit on Error');
}
// run the wizard tabbed pages
$web->run();
?>