<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 19.12.12
 * Time: 22:02
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
