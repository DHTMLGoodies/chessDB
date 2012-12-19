<?php

require_once("../autoload.php");

class SeekTest extends ChessTests{

    public function setUp(){
        parent::setUp();

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