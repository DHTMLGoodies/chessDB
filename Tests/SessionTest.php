<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 19.12.12
 * Time: 22:02
 */

require_once __DIR__."/../autoload.php";

class SessionTest extends ChessTests
{
    /**
     * @test
     */
    public function shouldBeAbleToCreateSession(){
        // given
        $user = $this->createUser('user','pass');

        $session = new Session();


    }
}
