<?php
/**
 * Reverse horizontal AJAX ProgressBar with red skin, using default Ajax driver.
 * This is the task handler part of default2.php example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 * @example    examples/ajax/default2task.php
 *             AJAX bgimages task handler source code
 */

/**
 * Simulate a user-task that will take many cycles to complete
 */
function processTask()
{
    $newVal = $_SESSION['progressPercentage'] + mt_rand(1, 25);
    $_SESSION['progressPercentage'] = min(100, $newVal);
    return $_SESSION['progressPercentage'];
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
    exit;
} elseif (isset($_REQUEST['TaskId'])) {
    // Proceed user-task on each polling loop
    if ($_REQUEST['TaskId'] != $_SESSION['taskId']) {
        die('wrong task id');
    }
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
}
?>
<progress id="<?php echo $_SESSION['progressId']; ?>" taskId="<?php echo $_SESSION['taskId']; ?>">
 <percentage><?php echo processTask(); ?></percentage>
</progress>