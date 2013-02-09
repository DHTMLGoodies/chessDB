<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 08.01.13
 */
require_once(__DIR__."/../autoload.php");

class MetadataTest extends ChessTests
{
    private static $dbConstructed = false;

    public function setUp()
    {
        parent::setUp();
        if (!self::$dbConstructed) {
            self::$dbConstructed = true;


            $mv = new MetadataValue();
            $mv->drop()->yesImSure();



            $m = new Metadata();
            $m->drop()->yesImSure();

            $m->createTable();
            $mv->createTable();


        }
    }

    /**
     * @test
     */
    public function shouldBeAbleToCreateMetadata()
    {
        // given
        $m = new Metadata('White');

        // then
        $this->assertNotNull($m->getId());
    }

    /**
     * @test
     */
    public function shouldBeAbleToCreateMetadataForAGame()
    {
        // given
        $m = new MetadataValue();
        $game = new Game();
        $game->setDatabaseId(1);
        $game->commit();
        // when
        $m->setGameId(1);
        $m->setMetadataKey('Black');
        $m->setMetadataValue('Magnus Carlsen');
        $m->commit();
        $id = $m->getId();

        $m = new MetadataValue(1, 'Black');

        // then
        $this->assertEquals($id, $m->getId());
    }

    /**
     * @test
     */
    public function shouldGetMetadataCollection(){
        // given
        $this->createGameMetadata(1, 'White', 'Magnus Carlsen');
        $this->createGameMetadata(1, 'Black', 'Levon Aronian');
        $this->createGameMetadata(1,'Result', '*');

        // when
        $c = new MetadataCollection(1);
        $values = $c->getValues();

        // then
        $this->assertEquals(3, count($values));
        $this->assertEquals('Magnus Carlsen', $values['White']);
        $this->assertEquals('Levon Aronian', $values['Black']);
        $this->assertEquals('*', $values['Result']);

    }


    /**
     * @test
     */

    public function shouldBeAbleToCreateMetadataForMoreGames(){
        // given
        $this->createGameMetadata(1, 'White', 'Magnus Carlsen');
        $this->createGameMetadata(1, 'Black', 'Levon Aronian');
        $this->createGameMetadata(1,'Result', '*');

        // given
        $this->createGameMetadata(2, 'White', 'Magnus Carlsen');
        $this->createGameMetadata(2, 'Black', 'Levon Aronian');
        $this->createGameMetadata(2,'Result', '*');

        // when
        $c = new MetadataCollection(1);
        $values = $c->getValues();
        $c2 = new MetadataCollection(2);
        $values2 = $c2->getValues();

        // then
        $this->assertEquals(3, count($values));
        $this->assertEquals(3, count($values2));
    }

    private function createGameMetadata($gameId, $key, $value){
        // given
        $game = new Game($gameId);
        if(!$game->getId()){
            $game->setValues(array("id", $gameId, "white" => "Alf"));
            $game->commit();
        }


        $m = new MetadataValue($key);
        // when
        $m->setGameid($gameId);
        $m->setMetadataKey($key);
        $m->setMetadataValue($value);
        $m->commit();
    }


}
