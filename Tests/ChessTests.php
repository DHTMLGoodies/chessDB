<?php

class ChessTests extends PHPUnit_Framework_TestCase
{
    private $connected = false;
    public function setUp(){
        if(!$this->connected){
            LudoDB::setHost('localhost');
            LudoDB::setUser('root');
            LudoDB::setPassword('administrator');
            LudoDB::setDb('PHPUnit');
            $this->connected = true;
        }
    }

    protected function createUser($username, $password){
        $player = new Player();
        if(!$player->exists())$player->createTable();
        $player->setUsername($username);
        $player->setPassword($password);
        $player->commit();
        return $player;
    }
}
