<?php

class ChessTests extends PHPUnit_Framework_TestCase
{
    private $connected = false;
    private static $logCleared = false;

    public function setUp(){
        if(!$this->connected){
            LudoDB::setHost('localhost');
            LudoDB::setUser('root');
            LudoDB::setPassword('administrator');
            LudoDB::setDb('PHPUnit');
            $this->connected = true;
        }
        if(!self::$logCleared){
            self::$logCleared = true;
            $this->clearLog();
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

    private function clearLog(){
        $fh = fopen("sql.txt", "w");
        fwrite($fh, "\n");
        fclose($fh);
    }

    protected function log($data){
        if(is_array($data))$data = json_encode($data);
        $fh = fopen("sql.txt", "a+");
        fwrite($fh, $data);
        fclose($fh);

    }
}
