<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 09.02.13
 * Time: 19:56
 */
class ChessLogin implements LudoDBService
{
    private $username;
    private $password;

    const COOKIE_NAME = 'dhtml_chess_sesssion';

    public static function getValidServices(){
        return array("signin");
    }

    public function validateService($service, $arguments){
        return count($arguments) === 2;
    }

    public function cacheEnabled(){
        return false;
    }

    public function signIn($username, $password){
        $pl = new PlayerByUsernamePassword($username, $password);
        if($pl->getId()){
            $session = new Session();
            $session->setUserId($pl->getId());
            $session->commit();
            $this->setCookie($session);
            return $session;
        }
        return null;
    }

    private function setCookie(Session $session){
        setcookie(self::COOKIE_NAME, $session->getKey(), time() + $this->daysToSeconds(365));
    }

    private function daysToSeconds($days){
        return $days * 24 * 60 * 60;
    }

    public function authenticate($session){
        $session = new Session($session);
        return $session->getId() ? $session : null;
    }
}
