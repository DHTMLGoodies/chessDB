<?php

require_once(__DIR__."/../autoload.php");

class AllChessTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();
        $suite->setName('AllTests');
        $suite->addTestSuite("FenTest");
        $suite->addTestSuite("GameTest");
        $suite->addTestSuite("MetadataTest");
        $suite->addTestSuite("PlayerTest");
        $suite->addTestSuite("SeekTest");
        $suite->addTestSuite("ImportTest");
        $suite->addTestSuite("SessionTest");
        $suite->addTestSuite("EloTest");

        return $suite;
    }
}