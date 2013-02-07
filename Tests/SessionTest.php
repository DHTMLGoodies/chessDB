<?php
/**
 * Chess Session tests
 * User: Alf Magne Kalleland
 * Date: 19.12.12
 */

require_once __DIR__."/../autoload.php";

class ChessSessionTest extends ChessTests
{
    /**
     * @test
     */
    public function shouldBeAbleToCreateChessSession(){
        // given
        $user = $this->createUser('user','pass');

        $session = new ChessSession();


    }
}
