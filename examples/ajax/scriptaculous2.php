<?php
/**
 * Custom AJAX example that used Scriptaculous effect at end of user-task process.
 * Alternative to scriptaculous1.php that seems to be break (HTML_AJAX bug ?)
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */

require_once 'PEAR.php';
require_once 'HTML/Progress2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$pb = new HTML_Progress2();
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'txt1', 'Scriptaculous AJAX Progress2 example 2');
$pb->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'txt2', 'caption ...');
$pb->setLabelAttributes('txt2', array('valign' => 'bottom'));
$pb->setIdent('PB1');
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
$pb->registerAJAX('phpcb_server2.php', array('getPercentage'), array('all', 'scriptaculous'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Scriptaculous Ajax Progress2 example 2</title>
<style type="text/css">
<!--
<?php
    echo $pb->getStyle();
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
HTML_Progress2.serverCallback = 'getPercentage';
HTML_Progress2.onComplete = 'fadeIn';

function fadeIn()
{
    new Effect.Opacity(HTML_Progress2.widgetId, {duration:0.5, from:1.0, to:0.4});
}
//]]>
</script>
</head>
<body>

<a href="javascript:HTML_Progress2.start('<?php echo $pb->getIdent(); ?>');">Start</a>
<?php $pb->display(); ?>

</body>
</html>