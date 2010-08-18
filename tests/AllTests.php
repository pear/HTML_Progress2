<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'HTML_Progress2_AllTests::main');
}

require_once 'PHPUnit/TextUI/TestRunner.php';

require_once 'HTML_Progress2Test.php';

class HTML_Progress2_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PEAR - HTML_Progress2');

        $suite->addTestSuite('HTML_Progress2Test');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'HTML_Progress2_AllTests::main') {
    HTML_Progress2_AllTests::main();
}
