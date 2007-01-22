<?php
/**
 * Basic AJAX example that used an auto server to handle progress bar responses
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

if (isset($_GET['reload'])) {
    session_start();
    unset($_SESSION['progressPercentage']);
    session_destroy();
    die('Job is over !');
}

require_once 'PEAR.php';
require_once 'HTML/Progress2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

// set this flag to true if you want to reuse a pre-set external style sheet
//$reuseCSS = false;
$reuseCSS = true;

$pb = new HTML_Progress2();
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'txt1', 'Basic AJAX Progress2 example 2');
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'txt2', 'caption ...');
$pb->setLabelAttributes('txt2', array('valign' => 'bottom'));

if ($reuseCSS) {
    $pb->setIdent('PB1');
    $pb->setBorderAttributes('class=progressBorder');
    $pb->setCellAttributes('class=cell');
    $pb->setLabelAttributes('pct1', array(
        'class' => 'progressPercentLabel',
        'align' => 'center'
    ));
    $pb->importStyle('bluesand2.css');
} else {
    $pb->setCellCount(20);
    $pb->setCellAttributes(array(
        'active-color' => '#000084',
        'inactive-color' => '#3A6EA5',
        'width' => 25,
        'spacing' => 0,
        'background-image' => 'download.gif'
    ));
    $pb->setBorderPainted(true);
    $pb->setBorderAttributes('width=1 style=inset color=white');
    $pb->setLabelAttributes('pct1', array(
        'width' => 60,
        'font-size' => 10,
        'align' => 'center',
        'valign' => 'left'
    ));
}

$pb->registerAJAX('auto_server.php', array('requeststatus'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Basic Ajax Progress2 example 2</title>
<?php
if ($reuseCSS) {
    echo '<link rel="stylesheet" type="text/css" href="bluesand2.css"  />'."\n";
}
?>
<style type="text/css">
<!--
<?php
if (!$reuseCSS) {
    echo $pb->getStyle();
}
?>

body {background-color: #EEEEEE; }
 -->
</style>
<script type="text/javascript" src="HTML_Progress2.js"></script>
<?php
echo $pb->setupAJAX();
?>
<script type="text/javascript">
//<![CDATA[
HTML_Progress2.serverClassName  = 'RequestStatus';
HTML_Progress2.serverMethodName = 'updatePercentage';
//]]>
</script>
</head>
<body>

<a href="javascript:HTML_Progress2.start('<?php echo $pb->getIdent(); ?>');">Start</a>
<?php $pb->display(); ?>

</body>
</html>