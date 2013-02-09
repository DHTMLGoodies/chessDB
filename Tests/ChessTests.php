<?php

class ChessTests extends PHPUnit_Framework_TestCase
{
    private static $connected = false;
    private static $logCleared = false;

    public function setUp()
    {
        if (!self::$connected) {
            date_default_timezone_set('Europe/Berlin');

            LudoDB::setHost('localhost');
            LudoDB::setUser('root');
            LudoDB::setPassword('administrator');
            LudoDB::setDb('PHPUnit');
            self::$connected = true;
        }
        if (!self::$logCleared) {
            self::$logCleared = true;
            $this->clearLog();
        }

        $tables = array(
            'Move','MetadataValue','Game','Database','Folder','dhtmlChess/Fen','Player'
        );
        $util = new  LudoDBUtility();
        $util->dropAndCreate($tables);


    }

    public function createUser($username, $password)
    {
        $player = new Player();
        if (!$player->exists()) $player->createTable();
        $player->setUsername($username);
        $player->setPassword($password);
        $player->setOnlinePlayer('1');
        $player->commit();
        return $player;
    }

    private function clearLog()
    {
        $fh = fopen("sql.txt", "w");
        fwrite($fh, "\n");
        fclose($fh);
    }

    protected function log($data)
    {
        if (is_array($data)) $data = json_encode($data);
        $fh = fopen("sql.txt", "a+");
        fwrite($fh, $data);
        fclose($fh);
    }
}
