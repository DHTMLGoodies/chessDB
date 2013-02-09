<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 09.02.13
 * Time: 03:53
 */
class ChessDBInstaller implements LudoDBService
{
    private $classes = array(
        'Game','Move','Eco','Database','Folder','Metadata','MetadataValue',
        'Session','Seek','Chat','ChatMessage','ChatMessages','Fen','Player',
        'TimeControl'
    );
    public function install(){
        try{
            $this->validatePHP();
            $this->validateDBConnection();
            $this->checkIfInstalled();
            $this->createCacheTable();
            $this->createTables();
        }catch(LudoDBException $e){
            throw new LudoDBException($e->getMessage(), $e->getCode());
        }
    }

    private function checkIfInstalled(){
        if($this->isInstalled()){
            throw new LudoDBException("Database installation already completed. Use LudoDB::setDb('name_of_database'); to install DHTML Chess tables to a different database", 400);
        }
    }

    private function createCacheTable(){
        $util = new LudoDBUtility();
        $util->dropAndCreate(array("LudoDBCache"));
    }

    private function createTables(){
        $util = new LudoDBUtility();
        $util->dropAndCreate($this->classes);
    }

    private function validateDBConnection(){
        try{
            $dbName = LudoDBRegistry::get('DB_NAME');
            // TODO check possibility of connecting without specifying db
            LudoDB::setDb("information_schema");
            LudoDB::getInstance()->connect();
            LudoDB::setDb($dbName);
            LudoDB::createDatabase($dbName);
            LudoDB::getInstance()->connect();
        }catch(Exception $e){
            throw new LudoDBException("Cannot connect to database, error message: ". $e->getMessage(), 400);
        }
    }

    private function validatePHP(){
        if (!defined('PDO::ATTR_DRIVER_NAME')){
            LudoDB::setConnectionType("MYSQLI");
        }
        if(phpversion() < '5.3'){
            throw new Exception("PHP 5.3 or higher is required. Your version: ". phpversion());
        }
        if(!in_array('mod_rewrite', apache_get_modules())){
            throw new Exception("mod_rewrite module not activated on your web server");
        }
    }

    public function isInstalled(){
        $cl = new Game();
        return $cl->exists();
    }

    public function validateService($serviceName, $arguments){
        return count($arguments) === 0;
    }
    public function cacheEnabled(){
        return false;
    }
    public static function getValidServices(){
        return array("install");
    }
}
