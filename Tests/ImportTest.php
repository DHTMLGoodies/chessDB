<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xait0020
 * Date: 04.02.13
 * Time: 22:39
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
            $db->setId(1);
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
        $gameIds = $import->save(array(
            "file" => "pgn/test.pgn",
            "databaseId" => 1
        ));

        // then
        $this->assertEquals(2, count($gameIds));
    }

    /**
     * @test
     */
    public function shouldStoreDatabaseId(){
        // given
        $import = new GameImport();

        // when
        $gameIds = $import->save(array(
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
        $gameIds = $import->save(array(
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
        $gameIds = $import->save(array(
            "file" => "pgn/test.pgn",
            "databaseId" => 1
        ));

        // when
        $game = new Game($gameIds[0]);
        $metadata = $game->getMetadata();

        // then
        $this->assertEquals("Computer chess game", $metadata['event']);
        $this->assertEquals("Grunfeld", $metadata['opening']);
        $this->assertEquals("21", $metadata['plycount']);
    }
}
