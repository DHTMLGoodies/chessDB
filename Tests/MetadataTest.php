<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 08.01.13
 * Time: 08:53
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

            $m = new Metadata();
            $m->drop()->yesImSure();
            $m->createTable();

            $m = new MetadataValue();
            $m->drop()->yesImSure();
            $m->createTable();
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
        // when
        $m->setGameid(1);
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
        $this->createGameMetadata(10, 'White', 'Magnus Carlsen');
        $this->createGameMetadata(10, 'Black', 'Levon Aronian');
        $this->createGameMetadata(10,'Result', '*');

        // when
        $c = new MetadataCollection(10);
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
        $this->createGameMetadata(10, 'White', 'Magnus Carlsen');
        $this->createGameMetadata(10, 'Black', 'Levon Aronian');
        $this->createGameMetadata(10,'Result', '*');

        // given
        $this->createGameMetadata(11, 'White', 'Magnus Carlsen');
        $this->createGameMetadata(11, 'Black', 'Levon Aronian');
        $this->createGameMetadata(11,'Result', '*');

        // when
        $c = new MetadataCollection(10);
        $values = $c->getValues();
        $c2 = new MetadataCollection(11);
        $values2 = $c->getValues();

        // then
        $this->assertEquals(3, count($values));
        $this->assertEquals(3, count($values2));
    }

    private function createGameMetadata($gameId, $key, $value){
        // given
        $m = new MetadataValue($key);
        // when
        $m->setGameid($gameId);
        $m->setMetadataKey($key);
        $m->setMetadataValue($value);
        $m->commit();
    }


}
