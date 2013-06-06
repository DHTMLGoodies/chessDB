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

            LudoDBRegistry::set('FILE_UPLOAD_PATH', '/tmp/');
        }
        if (!self::$logCleared) {
            self::$logCleared = true;
            $this->clearLog();
        }

        $classes = array(
            'Game','Move','Database','Folder','Metadata','MetadataValue',
            'Session','Seek','Chat','ChatMessage','ChatMessages','Fen','Player',
            'TimeControl','ChessFileUpload','Elo','PasswordLookup'
        );
        $util = new  LudoDBUtility();
        $util->dropAndCreate($classes);

        $this->createAdminUserAndSignIn();
    }

    private function createAdminUserAndSignIn(){

        $pl = new Player();
        $pl->grantAdminAccess();
        $pl->setUsername('alfmagne');
        $pl->setPassword(md5('Test25ab'));
        $pl->commit();



        $session = new Session();
        $session->signIn(array('username' => 'alfmagne', 'password' => md5('Test25ab')));

        #die(CurrentPlayer::getInstance()->getUserAccess());
    }

    public function createUser($username, $password)
    {
        $player = new Player();
        if (!$player->exists()) $player->createTable();
        $player->setUsername($username);
        $player->setPassword($password);
        $player->setEmail('post@dhtmlgoodies.com');
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
