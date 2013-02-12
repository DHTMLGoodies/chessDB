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
        ini_set('display_errors','on');
        $this->createUser("username","Pass1234");
        LudoDB::enableSqlLogging();
        /// when
        $login = new Session();
        $session = $login->signIn(array(
            "username" => "username",
            "password" => md5("Pass1234"))
        );

        // then
        $this->assertNotNull($session);
    }

    /**
     * @test
     */
    public function shouldBeAbleToAuthenticateSession(){
        // given
        $username = 'username';
        $password = 'Pass1234';

        $this->createUser($username, $password);

        $login = new Session();
        $session = $login->signIn(array(
            'username' => $username, 'password' => md5($password)
        ));
        $key = $session->getKey();

        // when
        $auth = new Session();
        $session = $auth->authenticate($key);

        // then
        $this->assertNotNull($session);
    }

    /**
     * @test
     */
    public function shouldGetLoggedOnUser(){
        // given
        $username = 'username';
        $password = 'Pass1234';

        $this->createUser($username, $password);

        $login = new Session();
        $key = $login->signIn(array(
            'username' => $username, 'password' => md5($password)
        ));
        $_COOKIE[ChessRegistry::getCookieName()] = $key;

        // when
        $user = $login->getUser();

        // then
        $this->assertNotNull($user);
        $this->assertEquals(1, $user->getId());
        $this->assertEquals("username", $user->getUsername());


    }
}
