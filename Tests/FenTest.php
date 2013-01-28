<?php

require_once(__DIR__."/../autoload.php");
error_reporting(E_ALL);
ini_set('display_errors','on');
class FenTest extends ChessTests
{
    public function setUp(){
        parent::setUp();
        $fen = new Fen();
        $fen->drop()->yesImSure();
        $fen->createTable();
    }

    /**
     * @test
     */
    public function shouldCreateNewRecordWhenFenIsNotFound(){
        // given
        $fen = new Fen("rnbqkbnr\/pppppppp\/8\/8\/8\/8\/PPPPPPPP\/RNBQKBNR w KQkq - 0 1");

        // then
        $this->assertNotNull($fen->getId());
    }

    /**
     * @test
     */
    public function shouldNotAutoCreateFenWhenExists(){
        // given
        $fen = new Fen("rnbqkbnr\/pppppppp\/8\/8\/8\/8\/PPPPPPPP\/RNBQKBNR w KQkq - 0 1");
        $fen2 = new Fen("rnbqkbnr\/pppppppp\/8\/8\/8\/8\/PPPPPPPP\/RNBQKBNR w KQkq - 0 1");

        // then
        $this->assertEquals($fen->getId(), $fen2->getId());


    }
}
