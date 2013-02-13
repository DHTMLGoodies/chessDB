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
        $login = new Session();
        $login->signIn(array(
            "username" => "username",
            "password" => md5("Pass1234"))
        );

        // then
        $this->assertNotNull($login->getKey());
        $this->assertTrue($login->isSignedIn());
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
        $login->signIn(array(
            'username' => $username, 'password' => md5($password)
        ));
        $key = $login->getKey();

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

        // when
        $login = new Session();
        $login->signIn(array(
            'username' => $username, 'password' => md5($password)
        ));
        $this->mockCookie($login->getKey());
        $user = $login->getUser();

        // then
        $this->assertNotNull($user);

        $this->assertEquals(1, $user->getId());
        $this->assertEquals("username", $user->getUsername());

        $player = new CurrentPlayer();
        $this->assertEquals($user->getValues(), $player->getValues());


    }

    private function mockCookie($key){
        $_COOKIE[ChessRegistry::getCookieName()] = $key;
    }
}
