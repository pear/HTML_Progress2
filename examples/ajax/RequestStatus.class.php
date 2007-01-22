<?php
/**
 * Sample of user-task script, that also handle response for progress meter
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @access     public
 */
class RequestStatus
{
    var $status = array('labels' => array(), 'percentage' => 0);

    function RequestStatus()
    {
        if (!isset($_SESSION['progressPercentage'])) {
            $_SESSION['progressPercentage'] = 0;
        }
    }

    /**
     * Returns only new percentage value
     *
     * @return  array
     * @access  public
     */
    function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns new percentage value with associate new labels values.
     *
     * You can define label value even, if its not declared in progress bar;
     * no error will be raised.
     * See example default3.php and label id 'txt4' usage
     *
     * @return  array
     * @access  public
     */
    function getFullStatus()
    {
        $status = $this->getStatus();

        if ($status['percentage'] < 25) {
            $this->status['labels']['txt1'] = '1st quarter';
            $this->status['labels']['txt2'] = 'Q1';
        } elseif ($status['percentage'] < 50) {
            $this->status['labels']['txt1'] = '2nd quarter';
            $this->status['labels']['txt2'] = 'Q2';
        } elseif ($status['percentage'] < 75) {
            $this->status['labels']['txt1'] = '3rd quarter';
            $this->status['labels']['txt2'] = 'Q3';
        } else {
            $this->status['labels']['txt1'] = '4th quarter';
            $this->status['labels']['txt4'] = 'Q4';
        }

        return $this->status;
    }

    /**
     * Move on current user-task and returns full status of progress meter.
     *
     * Here we simulate a user-task that take many cycles to complete, and we
     * don't know how many.
     *
     * @return  array
     * @access  public
     */
    function updateTask()
    {
        $this->_updateStatus();
        return $this->getFullStatus();
    }

    /**
     * Move on current user-task and returns only new percentage of progress meter.
     *
     * Here we simulate a user-task that take many cycles to complete, and we
     * don't know how many.
     *
     * @return  array
     * @access  public
     */
    function updatePercentage()
    {
        $this->_updateStatus();
        return $this->getStatus();
    }

    /**
     * Updates only progress meter status
     *
     * @return  void
     * @access  private
     */
    function _updateStatus()
    {
        $newVal = $_SESSION['progressPercentage'] + mt_rand(1, 25);
        $_SESSION['progressPercentage'] = min(100, $newVal);
        $this->status['percentage'] = $_SESSION['progressPercentage'];
    }
}
?>