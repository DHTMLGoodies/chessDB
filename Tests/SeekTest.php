<?php

require_once(__DIR__."/../autoload.php");

class SeekTest extends ChessTests{

    public function setUp(){
        parent::setUp();

        $seek = new Seek();
        $seek->drop()->yesImSure();


        $tc = new TimeControl();
        $tc->drop()->yesImSure();

        $tc->createTable();
        $seek->createTable();
    }
    /**
     * @test
     */
    public function shouldBeAbleToCreateSeek(){
        // given

    }

    /**
     * @test
     */
    public function shouldBeAbleToGetSeeksForAUser(){


    }

}