<?php
/**
 * Natural horizontal AJAX ProgressBar with blue skin, using default Ajax driver.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/ajax/default1.php
 *             AJAX bluesand source code
 * @link       http://www.laurent-laville.org/img/progress/screenshot/bluesand.png
 *             screenshot (Image PNG, 190x40 pixels) 352 bytes
 */
require_once 'PEAR.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

/**
 * Simulate a user-task that will take 9 cycles to complete (12% on each cycle)
 */
function processTask()
{
    $_SESSION['progressPercentage'] = $_SESSION['progressPercentage'] + 12;
    $percent = min(100, $_SESSION['progressPercentage']);
    return $percent;
}

session_start();

if (isset($_REQUEST['registerTask'])) {
    // Negociate a new task identifier
    $_SESSION['taskId'] = mt_rand();
    $_SESSION['progressId'] = $_REQUEST['registerTask'];
    $_SESSION['progressPercentage'] = 0;
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>
<progress id="<?php echo $_SESSION['progressId']; ?>" taskId="<?php echo $_SESSION['taskId']; ?>" />
<?php
} elseif (isset($_REQUEST['TaskId'])) {
    // Proceed user-task on each polling loop
    if ($_REQUEST['TaskId'] != $_SESSION['taskId']) {
        die('wrong task id');
    }
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>
<progress id="<?php echo $_SESSION['progressId']; ?>" taskId="<?php echo $_SESSION['taskId']; ?>">
 <percentage><?php echo processTask(); ?></percentage>
</progress>
<?php
} else {
    // Initialize progress bar render with initial page content
    include_once 'HTML/Progress2.php';

    $pb = new HTML_Progress2();
    $pb->setIdent('PB1');
    $pb->setIncrement(10);
    $pb->setBorderAttributes('class=progressBorder');
    $pb->setCellAttributes('class=cell');
    $pb->setLabelAttributes('pct1', array(
      'class' => 'progressPercentLabel',
      'align' => 'center'
      ));
    $pb->importStyle('bluesand2.css');

    $ae = $pb->registerAjax();
    $ae->setRequestUri(basename(__FILE__));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>BlueSand Ajax Progress2 example</title>
<link rel="stylesheet" type="text/css" href="bluesand2.css"  />
<style type="text/css">
<!--
body {background-color: #EEEEEE; }
 -->
</style>
<script type="text/javascript" src="progress2Handler.js"></script>
<script type="text/javascript" src="Poly9UrlParser.js"></script>
<script type="text/javascript">
//<![CDATA[
<?php echo $ae->getScript(true); ?>
function complete()
{
   // nothing do to at end, when server-side operation complete
   // JS function declaration avoid a JS error on javascript console
}
//]]>
</script>
</head>
<body>

<?php
$pb->display();
?>
<script type="text/javascript">
//<![CDATA[
<?php
$m = $ae->getRequestMethod();
if ($m != 'GET') {
    echo "reqMethod = '$m';\n";
}
$t = $ae->getRequestTimeout();
if ($t != 2000) {
    echo "timeout = '$t';\n";
}
echo "url1 = '". $ae->getRequestUri(1) ."';\n";
echo "url2 = '". $ae->getRequestUri(2) ."';\n";
?>
startTask();
//]]>
</script>

</body>
</html>
<?php
}
?>