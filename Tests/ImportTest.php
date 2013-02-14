<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 04.02.13
 */
error_reporting(E_ALL);
ini_set('display_errors','on');
require_once __DIR__ . "/../autoload.php";
require_once __DIR__ . "/../../parser/FenParser0x88.php";
require_once __DIR__ . "/../../parser/Board0x88Config.php";
require_once __DIR__ . "/../../parser/GameParser.php";
require_once __DIR__ . "/../../parser/PgnParser.php";
require_once __DIR__ . "/../../parser/PgnGameParser.php";
require_once __DIR__ . "/../../parser/MoveBuilder.php";
require_once __DIR__ . "/../../CHESS_JSON.php";


class ImportTest extends ChessTests
{

    public function setUp(){
        parent::setUp();

        $mv = new MetadataValue();
        $mv->drop()->yesImSure();

        $m = new Move();
        $m->drop()->yesImSure();
        $g = new Game();
        $g->drop()->yesImSure();

        $g->createTable();
        $m->createTable();
        $mv->createTable();

        $db = new Database(1);
        if(!$db->getId()){
            $db->setTitle('My database');
            $db->commit();
        }
    }
    /**
     * @test
     */
    public function shouldBeAbleToImportGames(){
        // given
        $import = new GameImport();

        // when
        $gameIds = $import->import(array(
            "file" => "pgn/test.pgn",
            "databaseId" => 1
        ));

        // then
        $this->assertEquals(8, count($gameIds));
    }

    /**
     * @test
     */
    public function shouldStoreDatabaseId(){
        // given
        $import = new GameImport();

        // when
        $gameIds = $import->import(array(
            "file" => "pgn/test.pgn",
            "databaseId" => 1
        ));
        $game = new Game($gameIds[0]);

        // then
        $this->assertEquals(1, $game->getDatabaseId());
    }

    /**
     * @test
     */
    public function shouldSaveMoves(){
        // given
        $import = new GameImport();
        $gameIds = $import->import(array(
            "file" => "pgn/test.pgn",
            "databaseId" => 1
        ));

        // when
        $game = new Game($gameIds[0]);
        $moves = $game->getMoves();

        // then
        $this->assertEquals(21, count($moves));
    }

    /**
     * @test
     */
    public function shouldSaveMetadata(){
        // given
        $import = new GameImport();
        $gameIds = $import->import(array(
            "file" => "pgn/test.pgn",
            "databaseId" => 1
        ));

        // when
        $game = new Game($gameIds[0]);
        $metadata = $game->getMetadata();

        // then
        $this->assertEquals("unterminated", $game->getTermination());
        $this->assertEquals("Grunfeld", $metadata['opening']);
        $this->assertEquals("21", $game->getPlycount());
    }

    /**
     * @test
     */
    public function shouldImportGamesInAcceptableTime(){
        // given
        $this->startTimer();
        $import = new GameImport();

        // when
        $games = $import->import(array(
            "file" => "pgn/test-timer.pgn",
            "databaseId" => 1
        ));
        $time = $this->getElapsed(__FUNCTION__);

        // then
        $this->assertEquals(25, count($games));
        $this->assertLessThan(12.5, $time);
    }

    private $startTime;
    private function startTimer(){
        $this->startTime = $this->getTime();
    }

    private function getTime(){
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    private function getElapsed($test){
        $ret = $this->getTime() - $this->startTime;
        $ret = number_format($ret, 3);
        $this->logTime($test, $ret);
        return $ret;
    }

    private function logTime($test, $elapsed){

        $time = new TestTimer();
        if(!$time->exists())$time->createTable();
        $time->setTestName("TEST: ". $test);
        $time->setTestTime($elapsed);
        $time->setTestDate(date("Y-m-d H:i:s"));
        $time->commit();
    }


}
