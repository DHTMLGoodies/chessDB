<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 08.01.13
 * Time: 08:53
 */
require_once("../autoload.php");

class MetadataTest extends ChessTests
{
    private static $dbConstructed = false;

    public function setUp()
    {
        parent::setUp();
        if (self::$dbConstructed) {
            self::$dbConstructed = true;

            $m = new Metadata();
            $m->drop();
            $m->createTable();

            $m = new MetadataValue();
            $m->drop();
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
        $m = new MetadataValue('Black');
        // when
        $m->setGameid(1);
        $m->setMetadataKey('Black');
        $m->setMetadataValue('Magnus Carlsen');
        $m->commit();
        $id = $m->getId();

        $m = new MetadataValue($id);

        // then
        $this->assertEquals(1, $m->getMetadataId());

    }
}
