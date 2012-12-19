<?php

class ChessTests extends PHPUnit_Framework_TestCase
{
    private $connected = false;
    public function setUp(){
        if(!$this->connected){
            $conn = mysql_connect('localhost','root','administrator');
            mysql_select_db('PHPUnit',$conn);;
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
