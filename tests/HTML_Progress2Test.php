<?php
require_once 'HTML/Progress2.php';
/**
 * Unit tests for HTML_Progress2 class.
 *
 * @version    $Id: HTML_Progress2_TestCase_setValue.php 193839 2005-08-18 09:40:39Z farell $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @ignore
 */

class HTML_Progress2Test extends PHPUnit_Framework_TestCase
{
    /**
     * HTML_Progress2 instance
     *
     * @var        object
     */
    var $progress;

    function setUp()
    {
        $prefs= array('push_callback' => array(&$this, '_handleError'));
//        $this->progress = new HTML_Progress2($prefs, HTML_PROGRESS2_BAR_HORIZONTAL, 10, 100);
        $this->progress = new HTML_Progress2($prefs);
    }

    function tearDown()
    {
        unset($this->progress);
    }

    function _methodExists($name)
    {
        if (substr(PHP_VERSION,0,1) < '5') {
            $n = strtolower($name);
        } else {
            $n = $name;
        }
        if (in_array($n, get_class_methods($this->progress))) {
            return true;
        }
        $this->fail('method '. $name . ' not implemented in ' . get_class($this->progress));
        return false;
    }

    function _handleError($code, $level)
    {
        // don't die if the error is an exception (as default callback)
        return PEAR_ERROR_RETURN;
    }

    function _getResult()
    {
        if ($this->progress->hasErrors()) {
            $err = $this->progress->getError();
            $msg = $err->getMessage() . '&nbsp;&gt;&gt;';
            $this->fail($msg);
        } else {
            $this->assertTrue(true);
        }
    }

    /**
     * TestCases for method setValue().
     */
    function test_setValue_fail_no_integer()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $result = $this->progress->setValue('25');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setValue_fail_less_than_min()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->progress->setMinimum(2);
        $result = $this->progress->setValue(1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setValue_fail_greater_than_max()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->progress->setMaximum(100);
        $result = $this->progress->setValue(200);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setValue()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->progress->setValue(15);
        $this->_getResult();
    }


    /**
     * TestCases for method setMaximum().
     */
    function test_setMaximum_fail_no_integer()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $result = $this->progress->setMaximum('100');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setMaximum_fail_no_positive()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $result = $this->progress->setMaximum(-1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setMaximum_fail_less_min()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->progress->setMinimum(2);
        $result = $this->progress->setMaximum(1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setMaximum()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->progress->setMaximum(10);
        $this->_getResult();
    }


    /**
     * TestCases for method moveStep().
     */
    function test_moveStep_fail_no_integer()
    {
        if (!$this->_methodExists('moveStep')) {
            return;
        }
        $result = $this->progress->moveStep('25');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_moveStep_fail_less_than_min()
    {
        if (!$this->_methodExists('moveStep')) {
            return;
        }
        $this->progress->setMinimum(1);
        $result = $this->progress->moveStep(-1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_moveStep_fail_greater_than_max()
    {
        if (!$this->_methodExists('moveStep')) {
            return;
        }
        $this->progress->setMaximum(2);
        $result = $this->progress->moveStep(200);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_moveStep()
    {
        if (!$this->_methodExists('moveStep')) {
            return;
        }
        $this->progress->moveStep(15);
        ob_end_clean();
    }


    /**
     * TestCases for method addLabel().
     */
    function test_addLabel_fail_label_type_invalid()
    {
        if (!$this->_methodExists('addLabel')) {
            return;
        }
        $result = $this->progress->addLabel('longtext', 'lng1');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_addLabel_fail_label_name_invalid()
    {
        if (!$this->_methodExists('addLabel')) {
            return;
        }
        $result = $this->progress->addLabel('text', 1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_addLabel_fail_label_value_invalid()
    {
        if (!$this->_methodExists('addLabel')) {
            return;
        }
        $result = $this->progress->addLabel(HTML_PROGRESS2_LABEL_TEXT, 'txt1', null);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_addLabel_fail_label_exists()
    {
        if (!$this->_methodExists('addLabel')) {
            return;
        }
        $result = $this->progress->addLabel(HTML_PROGRESS2_LABEL_PERCENT, 'pct1');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_addLabel()
    {
        if (!$this->_methodExists('addLabel')) {
            return;
        }
        $result = $this->progress->addLabel(HTML_PROGRESS2_LABEL_BUTTON, 'btn1', 'OK');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }


    /**
     * TestCases for method setString().
     */
    function test_setString_fail_no_string()
    {
        if (!$this->_methodExists('setString')) {
            return;
        }
        $result = $this->progress->setString(true);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setString()
    {
        if (!$this->_methodExists('setString')) {
            return;
        }
        $this->progress->setString(null);
    }


    /**
     * TestCases for method addListener().
     */
    function test_addListener_fail_no_class()
    {
        if (!$this->_methodExists('addListener')) {
            return;
        }
        $observer = 'logit';
        $result = $this->progress->addListener($observer);

        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_addListener()
    {
        $this->fail("This appears to cause a load average of 5 on my PHP 5.3 machine");
        if (!$this->_methodExists('addListener')) {
            return;
        }

        $monitor = $this->progress->addListener(new log_progress());

        $this->assertTrue($monitor, $observer .' is not a valid listener ');
    }


    /**
     * TestCases for method drawCircleSegments().
     */
    function test_drawCircleSegments_fail_wrong_directory()
    {
        if (!$this->_methodExists('drawCircleSegments')) {
            return;
        }
        $result = $this->progress->drawCircleSegments('./nodir');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_drawCircleSegments()
    {
        if (!$this->_methodExists('drawCircleSegments')) {
            return;
        }
        $this->progress->drawCircleSegments();
        $this->_getResult();
    }


    /**
     * TestCases for method getBorderAttributes().
     */
    function test_getBorderAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getBorderAttributes')) {
            return;
        }
        $result = $this->progress->getBorderAttributes('true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_getBorderAttributes()
    {
        if (!$this->_methodExists('getBorderAttributes')) {
            return;
        }
        $this->progress->getBorderAttributes(true);
        $this->_getResult();
    }


    /**
     * TestCases for method getCellAttributes().
     */
    function test_getCellAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getCellAttributes')) {
            return;
        }
        $result = $this->progress->getCellAttributes('true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_getCellAttributes()
    {
        if (!$this->_methodExists('getCellAttributes')) {
            return;
        }
        $this->progress->getCellAttributes(true);
        $this->_getResult();
    }

    /**
     * TestCases for method getPercentComplete().
     */
    function test_getPercentComplete_fail_no_boolean()
    {
        if (!$this->_methodExists('getPercentComplete')) {
            return;
        }
        $result = $this->progress->getPercentComplete('true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_getPercentComplete()
    {
        if (!$this->_methodExists('getPercentComplete')) {
            return;
        }
        $this->progress->getPercentComplete();
        $this->_getResult();
    }

    /**
     * TestCases for method getLabelAttributes().
     */
    function test_getLabelAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getLabelAttributes')) {
            return;
        }
        $result = $this->progress->getLabelAttributes('pct1', 'true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_getLabelAttributes_fail_invalid_label()
    {
        if (!$this->_methodExists('getLabelAttributes')) {
            return;
        }
        $result = $this->progress->getLabelAttributes('legend', true);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_getLabelAttributes()
    {
        if (!$this->_methodExists('getLabelAttributes')) {
            return;
        }
        $this->progress->getLabelAttributes('pct1', true);
        $this->_getResult();
    }

    /**
     * TestCases for method getFrameAttributes().
     */
    function test_getFrameAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getFrameAttributes')) {
            return;
        }
        $result = $this->progress->getFrameAttributes('true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_getFrameAttributes()
    {
        if (!$this->_methodExists('getFrameAttributes')) {
            return;
        }
        $this->progress->getFrameAttributes(true);
        $this->_getResult();
    }

    /**
     * TestCases for method removeListener().
     */
    function test_removeListener_fail_no_class()
    {
        if (!$this->_methodExists('removeListener')) {
            return;
        }
        $observer = 'log_progress2';
        $result = $this->progress->removeListener(new $observer);

        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_removeListener()
    {
	$this->fail("This appears to cause massive performance problems");
        if (!$this->_methodExists('removeListener')) {
            return;
        }
        $observer = 'logit2';
        $monitor = $this->progress->addListener(new $observer);
        $monitor = $this->progress->removeListener(new $observer);

        $this->assertTrue($monitor, $observer .' is not a valid listener or is not yet attached ');
    }

    /**
     * TestCases for method removeLabel().
     */
    function test_removeLabel_fail_label_name_invalid()
    {
        if (!$this->_methodExists('removeLabel')) {
            return;
        }
        $result = $this->progress->removeLabel(1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_removeLabel_fail_label_not_exists()
    {
        if (!$this->_methodExists('removeLabel')) {
            return;
        }
        $result = $this->progress->removeLabel('txt1');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_removeLabel()
    {
        if (!$this->_methodExists('removeLabel')) {
            return;
        }
        $this->progress->removeLabel('pct1');
        $this->_getResult();
    }


    /**
     * TestCases for method setAnimSpeed().
     */
    function test_setAnimSpeed_fail_no_integer()
    {
        if (!$this->_methodExists('setAnimSpeed')) {
            return;
        }
        $result = $this->progress->setAnimSpeed('200');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setAnimSpeed_fail_no_positive()
    {
        if (!$this->_methodExists('setAnimSpeed')) {
            return;
        }
        $result = $this->progress->setAnimSpeed(-1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setAnimSpeed_fail_greater_max_allowed()
    {
        if (!$this->_methodExists('setAnimSpeed')) {
            return;
        }
        $result = $this->progress->setAnimSpeed(1500);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setAnimSpeed()
    {
        if (!$this->_methodExists('setAnimSpeed')) {
            return;
        }
        $this->progress->setAnimSpeed(100);
        $this->_getResult();
    }


    /**
     * TestCases for method setBorderPainted().
     */
    function test_setBorderPainted_fail_no_boolean()
    {
        if (!$this->_methodExists('setBorderPainted')) {
            return;
        }
        $result = $this->progress->setBorderPainted('true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setBorderPainted()
    {
        if (!$this->_methodExists('setBorderPainted')) {
            return;
        }
        $this->progress->setBorderPainted(true);
        $this->_getResult();
    }

    /**
     * TestCases for method setScript().
     */
    function test_setScript_fail_no_string()
    {
        if (!$this->_methodExists('setScript')) {
            return;
        }
        $result = $this->progress->setScript(100);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setScript_fail_no_file()
    {
        if (!$this->_methodExists('setScript')) {
            return;
        }
        $result = $this->progress->setScript('progress1.js');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setScript()
    {
        if (!$this->_methodExists('setScript')) {
            return;
        }
        $this->progress->setScript('progress2.js');
        $this->_getResult();
    }


    /**
     * TestCases for method setCellAttributes().
     */
    function test_setCellAttributes_fail_no_integer()
    {
        if (!$this->_methodExists('setCellAttributes')) {
            return;
        }
        $result = $this->progress->setCellAttributes('','1');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setCellAttributes_fail_no_positive()
    {
        if (!$this->_methodExists('setCellAttributes')) {
            return;
        }
        $result = $this->progress->setCellAttributes('',-1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setCellAttributes_fail_invalid_cellindex()
    {
        if (!$this->_methodExists('setCellAttributes')) {
            return;
        }
        $result = $this->progress->setCellAttributes('',11);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setCellAttributes()
    {
        if (!$this->_methodExists('setCellAttributes')) {
            return;
        }
        $this->progress->setCellAttributes('color = #FF0000');
        $this->_getResult();
    }


    /**
     * TestCases for method setCellCoordinates.
     *
     */
    function test_setCellCoordinates_fail_no_integer()
    {
        if (!$this->_methodExists('setCellCoordinates')) {
            return;
        }
        $result = $this->progress->setCellCoordinates('1',2);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setCellCoordinates_fail_no_positive()
    {
        if (!$this->_methodExists('setCellCoordinates')) {
            return;
        }
        $result = $this->progress->setCellCoordinates(-1,4);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setCellCoordinates_fail_too_small()
    {
        if (!$this->_methodExists('setCellCoordinates')) {
            return;
        }
        $result = $this->progress->setCellCoordinates(1,2);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setCellCoordinates()
    {
        if (!$this->_methodExists('setCellCoordinates')) {
            return;
        }
        $this->progress->setCellCoordinates(5,5);
        $this->_getResult();
    }


    /**
     * TestCases for method getProgressAttributes().
     */
    function test_getProgressAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getProgressAttributes')) {
            return;
        }
        $result = $this->progress->getProgressAttributes('true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_getProgressAttributes()
    {
        if (!$this->_methodExists('getProgressAttributes')) {
            return;
        }
        $this->progress->getProgressAttributes(true);
        $this->_getResult();
    }



    /**
     * TestCases for method setCellCount().
     */
    function test_setCellCount_fail_no_integer()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $result = $this->progress->setCellCount('20');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setCellCount_fail_less_0()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $result = $this->progress->setCellCount(-1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setCellCount_horizontal_valid_width()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->progress->setCellCount(1);
        $data = $this->progress->toArray();

        $this->assertEquals(19, $data['progress']['width'],
            'default-size HORIZONTAL-1-cell no-border : w=19 h=24.');
    }

    function test_setCellCount_vertical_valid_height()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->progress->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
        $this->progress->setCellCount(2);
        $data = $this->progress->toArray();

        $this->assertEquals(36, $data['progress']['height'],
            'default-size VERTICAL-2-cells no-border : w=24 h=36.');
    }

    function test_setCellCount()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->progress->setCellCount(16);

        $this->assertFalse($this->errorThrown, 'error thrown');
    }


    /**
     * TestCases for method setFillWay().
     */
    function test_setFillWay_fail_no_string()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $result = $this->progress->setFillWay(true);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setFillWay_fail_invalid_value()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $result = $this->progress->setFillWay('right');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setFillWay_natural()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $this->progress->setFillWay('natural');
        $this->_getResult();
    }


    /**
     * TestCases for method setFrameAttributes().
     */
    function test_setFrameAttributes_fail_no_array()
    {
        if (!$this->_methodExists('setFrameAttributes')) {
            return;
        }
        $result = $this->progress->setFrameAttributes('show=true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setFrameAttributes_fail_invalid_option()
    {
        if (!$this->_methodExists('setFrameAttributes')) {
            return;
        }
        $result = $this->progress->setFrameAttributes(array('display' => true));
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setFrameAttributes()
    {
        if (!$this->_methodExists('setFrameAttributes')) {
            return;
        }
        $this->progress->setFrameAttributes(null);
        $this->_getResult();
    }


    /**
     * TestCases for method setIncrement().
     */
    function test_setIncrement_fail_no_integer()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $result = $this->progress->setIncrement('1');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setIncrement_fail_zero()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $result = $this->progress->setIncrement(0);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setIncrement()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->progress->setIncrement(5);
        $this->_getResult();
    }


    /**
     * TestCases for method setIndeterminate().
     */
    function test_setIndeterminate_fail_no_boolean()
    {
        if (!$this->_methodExists('setIndeterminate')) {
            return;
        }
        $result = $this->progress->setIndeterminate('true');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setIndeterminate()
    {
        if (!$this->_methodExists('setIndeterminate')) {
            return;
        }
        $this->progress->setIndeterminate(true);
        $this->_getResult();
    }


    /**
     * TestCases for method setLabelAttributes().
     */
    function test_setLabelAttributes_fail_invalid_label()
    {
        if (!$this->_methodExists('setLabelAttributes')) {
            return;
        }
        $result = $this->progress->setLabelAttributes('pct2', 'width=0');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setLabelAttributes()
    {
        if (!$this->_methodExists('setLabelAttributes')) {
            return;
        }
        $this->progress->setLabelAttributes('pct1', 'width=0');
        $this->_getResult();
    }


    /**
     * TestCases for method setMinimum().
     */
    function test_setMinimum_fail_no_integer()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $result = $this->progress->setMinimum('0');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setMinimum_fail_no_positive()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $result = $this->progress->setMinimum(-1);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setMinimum_fail_greater_max()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $result = $this->progress->setMinimum(500);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setMinimum()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->progress->setMinimum(10);
        $this->_getResult();
    }


    /**
     * TestCases for method setOrientation().
     */
    function test_setOrientation_fail_no_integer()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $result = $this->progress->setOrientation('horizontal');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setOrientation_fail_invalid_value()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $result = $this->progress->setOrientation(0);
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_INPUT, $result->getCode());
    }

    function test_setOrientation_vertical_valid_width()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->progress->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
        $data = $this->progress->toArray();

        $this->assertEquals(24, $data['progress']['width'],
            'default-size VERTICAL no-border : w=24 h=172.');
    }

    function test_setOrientation_vertical_valid_height()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->progress->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
        $data = $this->progress->toArray();

        $this->assertEquals(172, $data['progress']['height'],
            'default-size VERTICAL no-border : w=24 h=172.');
    }

    function test_setOrientation_vertical_valid_cell_width()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->progress->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
        $data = $this->progress->toArray();

        $this->assertEquals(20, $data['cell']['width'],
            'default-cell-size VERTICAL : w=20 h=15.');
    }

    function test_setOrientation_vertical_valid_cell_height()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->progress->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
        $data = $this->progress->toArray();

        $this->assertEquals(15, $data['cell']['height'],
            'default-cell-size VERTICAL : w=20 h=15.');
    }

    function test_setOrientation_vertical()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->progress->setOrientation(HTML_PROGRESS2_BAR_VERTICAL);
        $this->_getResult();
    }


    /**
     * TestCases for method setProgressHandler().
     */
    function test_setProgressHandler_fail_invalid_callback()
    {
        if (!$this->_methodExists('setProgressHandler')) {
            return;
        }
        $result = $this->progress->setProgressHandler('mycallback');
        $this->assertTrue($result instanceof HTML_Progress2_Error);
        $this->assertSame(HTML_PROGRESS2_ERROR_INVALID_CALLBACK, $result->getCode());
    }

    function test_setProgressHandler()
    {
        if (!$this->_methodExists('setProgressHandler')) {
            return;
        }
        $this->progress->setProgressHandler('lambda');
        $this->_getResult();
    }
}

require_once ('HTML/Progress2/Observer.php');
/**
 * @ignore
 */
class logit
{
}
/**
 * @ignore
 */
class log_progress extends HTML_Progress2_Observer
{
    function log_progress()
    {
    }
}


/**
 * @ignore
 */
class logit2 extends HTML_Progress2_Observer
{
    function logit2()
    {
    }
}
/**
 * @ignore
 */
class log_progress2
{
}
?>
