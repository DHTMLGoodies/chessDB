<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 19.12.12
 * Time: 22:20
 */

require_once(__DIR__."/../autoload.php");

class PlayerTest extends ChessTests
{
    public function setUp(){
        parent::setUp();
        $this->clearUserTable();
    }

    /**
     * @test
     */
    public function shouldNotBeAbleToCreateUserIfUsernameExists(){
        // given
        $user = $this->createUser('user1','pass1');
        $this->assertNotNull($user->getId());
        $secondUser = $this->createUser('user1','pass2');

        // then
        $this->assertNull($secondUser->getId());
        $this->assertFalse($secondUser->isValid());

    }

    /**
     * @test
     */
    public function shouldBeAbleToFindPlayerByUsernameAndPassword(){
        // given
        $this->createUser('user1','pass1');

        // when
        $finder = new PlayerFinder();
        $user = $finder->byUserNameAndPassword('user1','pass1');

        // then
        $this->assertEquals('user1', $user->getUsername());
        $this->assertEquals(md5('pass1'), $user->getPassword());
    }

    public function shouldBeAbleToFindPlayerBySession(){
        // given
        $user = $this->createUser('user','pass');

    }

    private function clearUserTable(){
        $player = new Player();
        if($player->exists())$player->deleteTableData();
    }


}
