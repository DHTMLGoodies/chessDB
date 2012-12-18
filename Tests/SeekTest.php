<?php

error_reporting(E_ALL);
ini_set('display_errors','on');
require_once("../../../db-connection.php");
require_once("../../../php/connect.php");
require_once("../../../autoloader.php");

class SeekTest extends PHPUnit_Framework_TestCase{

    public function setUp(){
        $seek = new Seek();
        $seek->drop();
        $seek->createTable();

        $tc = new TimeControl();
        $tc->drop();
        $tc->createTable();
    }
    /**
     * @test
     */
    public function shouldBeAbleToCreateSeek(){
        // given

    }

}