<?php
/**
 * Make package.xml and GNU TAR archive files for HTML_Progress2 class
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 */

require_once 'PEAR/Packager.php';
require_once 'PEAR/PackageFileManager.php';

function handleError($e) {

    if (PEAR::isError($e)) {
        die($e->getMessage());
    }
}

// Full description of the package
$description = <<<DESCR
This package provides a way to add a loading bar fully customizable in existing XHTML documents.
Your browser should accept DHTML feature.

Features:
- create horizontal, vertival bar and also circle, ellipse and polygons (square, rectangle).
- allows usage of existing external StyleSheet and/or JavaScript.
- all elements (progress, cells, labels) are customizable by their html properties.
- percent/labels are floating all around the progress meter.
- compliant with all CSS/XHMTL standards.
- integration with all template engines is very easy.
- implements Observer design pattern. It is possible to add Listeners.
- adds a customizable monitor pattern to display a progress bar.
  User-end can abort progress at any time.
- allows many progress meter on same page without uses of iframe solution.
- error handling system that support native PEAR_Error, but also PEAR_ErrorStack, and
  any other system you might want to plug-in.
- PHP 5 ready.
DESCR;

// Summary of description of the package
$summary = 'How to include a loading bar in your XHTML documents quickly and easily.';

// New version and state of the package
$version = '2.0.0RC1';
$state   = 'beta';

// Notes about this new release
$notes = <<<NOTE
---
  It is important to notice that even if i will continue to maintains the HTML_Progress
  for possible bugs, no features will be added in this package. Even if it will not marks
  as deprecated, i suggest to migrate to HTML_Progress2 (see docs/migrationGuide.txt).
---
* news
- The HTML_Progress2 package has now a series of mini guides (see docs/ directory)
- The HTML_Progress2_Lite class is recommended to users that does not want to install PEAR.
  This class has no dependencies.
- News examples are available: See Multiple, Label, Lite version, Preload.
- Adds the *autorun* option on HTML_Progress2_Monitor to run a progress monitor
  without need to push the Start button.

* changes
- DM and UI classes (from HTML_Progress 1.x) were merged into the main class.
- Model class (from HTML_Progress 1.x) was removed.
- A new error handling system that support native PEAR_Error (default), but also PEAR_ErrorStack,
  and any other system you might want to plug-in.
- Progress2 and Generator does not support anymore external pre-set config file.
- All examples have been revisited (removed those who have the same goals).
- HTML_Progress2::getPercentComplete() method has an optional parameter.
  Return may be float (default) or integer.
- HTML_Progress2 API changed a bit to include the new label system:
  . setCellCount() accept now zero as minimum value for smooth progress meter
    (see also HTML_Progress2_Lite).
  . moveNext() should replace incValue() (still exists)
  . moveStep() should replace setValue() (still exists)
  . setLabelAttributes() replaced setStringAttributes() (was removed)
  . isStringPainted() and setStringPainted() were removed
  . getString() was also removed
  . setString() was removed and replaced by addLabel()
- HTML_Progress2_Monitor::callProgressHandler() public method was removed.
- HTML_Progress2 included now the features of HTML_Progress_Lite:
  window frame, buttons, labels (text, step, crossbar).

* improvements
- Generator ActionProcess got two new methods to easily get PHP and/or CSS source code generated.
- More compatibilities with PHP5 (adds __construct method).

* QA
- Updates headers comment block on all files
- Dependencies has been revisited to higher level
- Examples were removed from main package and moved into the optional package
  available at http://pear.laurent-laville.org/HTML_Progress2/

NOTE;

// Configuration of PEAR::PackageFileManager
$options = array(
    'package'           => 'HTML_Progress2',
    'summary'           => $summary,
    'description'       => $description,
    'license'           => 'PHP License 3.0',
    'baseinstalldir'    => 'HTML',
    'version'           => $version,
    'packagedirectory'  => '.',
    'dir_roles'         => array('docs' => 'doc',
                                 'tests' => 'test',
                                 'Progress2' => 'php',
                                ),
    'state'             => $state,
    'filelistgenerator' => 'cvs',
    'changelogoldtonew' => false,
//    'simpleoutput'      => true,       // see bug#4604
    'notes'             => $notes,
    'ignore'            => array('package.xml', 'package.php',
                                 'examples.xml', 'examples.php',
                                 'Thumbs.db',
                                 'cache/', 'examples/'
                                ),
    'cleardependencies' => true
);


$pkg = new PEAR_PackageFileManager();

$e = $pkg->setOptions( $options );
handleError($e);

// Replaces version number only in necessary files
$phpfiles = array(
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
foreach ($phpfiles as $file) {
    $e = $pkg->addReplacement($file, 'package-info', '@package_version@', 'version');
    handleError($e);
}
// Maintainers List
$e = $pkg->addMaintainer( 'farell', 'lead', 'Laurent Laville', 'pear@laurent-laville.org' );
handleError($e);

// Dependencies List
$e = $pkg->addDependency('PHP', '4.2.0', 'ge', 'php');
handleError($e);
$e = $pkg->addDependency('PHP_Compat', '1.4.1', 'ge', 'pkg', false);
handleError($e);
$e = $pkg->addDependency('HTML_Common', '1.2.1', 'ge', 'pkg', false);
handleError($e);
$e = $pkg->addDependency('PEAR', '1.3.5', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_CSS', '0.3.4', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_QuickForm', '3.2.4', 'gt', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_QuickForm_Controller', '1.0.4', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('Image_Color', '1.0.1', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_Page2', '0.5.0', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_Template_IT', '1.1', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_Template_Sigma', '1.1.2', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('Log', '1.8.7', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('gd', false, 'has', 'ext', true);
handleError($e);

// Writes the new version of package.xml
if (isset($_GET['make'])) {
    $e = @$pkg->writePackageFile();
} else {
    $e = @$pkg->debugPackageFile();
}
handleError($e);

// Build the new binary package
if (!isset($_GET['make'])) {
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?make=1">Make this XML file</a>';
} else {
    $options = $pkg->getOptions();
    $pkgfile = $options['packagedirectory'] . DIRECTORY_SEPARATOR . $options['packagefile'];

    $pkgbin = new PEAR_Packager();

    $e = $pkgbin->package($pkgfile);
    handleError($e);
}
?>