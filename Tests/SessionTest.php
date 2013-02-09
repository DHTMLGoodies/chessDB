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
    public function shouldBeAbleToSignIn(){
        // given
        $this->createUser("username","Pass1234");
        LudoDB::enableSqlLogging();
        /// when
        $login = new ChessLogin();
        $session = $login->signIn("username", "Pass1234");

        // then
        $this->assertNotNull($session);

    }

    /**
     * @test
     */
    public function shouldBeAbleToAuthenticateSession(){
        // given
        $this->createUser("username","Pass1234");
        LudoDB::enableSqlLogging();
        $login = new ChessLogin();
        $session = $login->signIn("username", "Pass1234");
        $key = $session->getKey();

        // when
        $auth = new ChessLogin();
        $session = $auth->authenticate($key);

        // then
        $this->assertNotNull($session);




    }
}
