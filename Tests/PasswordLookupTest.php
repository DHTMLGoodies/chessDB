<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 06.06.13
 * Time: 22:16
 */

error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once __DIR__ . "/../autoload.php";


class PasswordLookupTest extends ChessTests
{
    public function setUp(){
        parent::setUp();
        $lookup = new PasswordLookup();
       // $lookup->deleteTableData()->yesImSure();
    }
    /**
     * @test
     */
    public function shouldBeAbleToCreatePasswordLookup(){
        // given
        $this->createPlayer();

        // when

        $handler = new LudoDBRequestHandler();
        $json = $handler->handle(array(
            'request' => 'PasswordLookup/save',
            'data' => array(
                'email' => 'player@dhtml-chess.com'
            )
        ));

        $data = json_decode($json, true);

        // then
        $this->assertTrue($data['success'], $json);

    }

    public function shouldThrowExceptionOnInvalidEmail(){
        // given
        $this->createPlayer();

        // when
        $handler = new LudoDBRequestHandler();
        $json = $handler->handle(array(
            'request' => 'PasswordLookup/save',
            'data' => array(
                'email' => 'invalid@dhtml-chess.com'
            )
        ));

        $data = json_decode($json, true);

        // then
        $this->assertFalse($data['success'], $json);

    }

    private function createPlayer(){
        $p = new Player();
        $p->setEmail('player@dhtml-chess.com');
        $p->commit();

    }
}
