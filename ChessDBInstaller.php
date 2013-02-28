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
        'Game', 'Move', 'Eco', 'Database', 'Folder', 'Metadata', 'MetadataValue',
        'Session', 'Seek', 'Chat', 'ChatMessage', 'ChatMessages', 'Fen', 'Player',
        'TimeControl', 'ChessFileUpload', 'Country','Elo'
    );

    public function install($details = null)
    {
        try {
            $this->writeLockFile();
            $this->validatePHP();
            if (isset($details)) {
                $this->setConnectionDetails($details);
            }
            $this->validateDBConnection();
            $this->checkIfInstalled();
            $this->createCacheTable();
            $this->createTables();
            if (isset($details)) {
                $this->createAdminUser($details);
            }

        } catch (LudoDBException $e) {
            throw new LudoDBException($e->getMessage(), $e->getCode());
        }
    }
    // TODO refactor the path in this function or figure out a better way to lock the installer
    private function writeLockFile(){
        $path = dirname(__FILE__)."/../../installer/chess.lock";
        file_put_contents($path, "locked");
        if(!file_exists($path)){
            throw new Exception("Installed, but could not write installer lock file to ". $path);
        }

    }

    private function createAdminUser($details)
    {
        if (isset($details['adminUserName']) && isset($details['adminUserName'])) {
            $pl = new Player();
            $pl->grantAdminAccess();
            $pl->setUsername($details['adminUserName']);
            $pl->setPassword($details['adminPassword']);
            $pl->commit();

            $session = new Session();
            $session->signIn(array('username' => $details['adminUserName'], 'password' => $details['adminPassword']));
        }
    }

    private function checkIfInstalled()
    {
        if ($this->isInstalled()) {
            throw new LudoDBException("DHTML Chess has already been installed to this database. Use the existing installation or specify a different database name", 400);
        }
    }

    private function createCacheTable()
    {
        $util = new LudoDBUtility();
        $util->dropAndCreate(array("LudoDBCache"));
    }

    private function createTables()
    {
        $util = new LudoDBUtility();
        $util->dropAndCreate($this->classes);
    }

    private function validateDBConnection()
    {
        try {
            $dbName = LudoDBRegistry::get('DB_NAME');
            LudoDB::setDb("information_schema");
            LudoDB::getInstance()->connect();
            LudoDB::setDb($dbName);
            LudoDB::createDatabase($dbName);
            LudoDB::getInstance()->connect();
        } catch (Exception $e) {
            throw new LudoDBException("Cannot connect to database, error message: " . $e->getMessage(), 400);
        }
    }

    private function validatePHP()
    {
        if (!defined('PDO::ATTR_DRIVER_NAME')) {
            LudoDB::setConnectionType("MYSQLI");
        }
        if (phpversion() < '5.3') {
            throw new Exception("PHP 5.3 or higher is required. Your version: " . phpversion());
        }
    }

    public function isInstalled()
    {
        $cl = new Game();
        return $cl->exists();
    }

    public function validateArguments($serviceName, $arguments)
    {
        return count($arguments) === 0;
    }

    public function validateServiceData($serviceName, $data)
    {
        return true;
    }

    public function shouldCache($service)
    {
        return false;
    }

    public function getValidServices()
    {
        return array("install", "validateConnection");
    }

    public function validateConnection($dbDetails)
    {
        $keys = array("host", "username", "password", "db");
        foreach ($keys as &$key) {
            if (!isset($dbDetails[$key])) {
                throw new LudoDBConnectionException("key " . $key . " is missing.");
            }
            $key = preg_replace("/[^a-z0-9_-]/si", "", $key);
        }
        $this->setConnectionDetails($dbDetails);
        try {
            LudoDB::getInstance();
        } catch (LudoDBException $e) {
            LudoDB::setDb("");
            LudoDB::getInstance()->connect();
            LudoDB::createDatabase($dbDetails['db']);
            $this->setConnectionSuccessMessage('Connection successful. Database ' . $dbDetails['db'] . " created");
        }
        return $dbDetails;
    }

    private function setConnectionDetails($dbDetails){
        LudoDB::setDb($dbDetails['db']);
        LudoDB::setUser($dbDetails['username']);
        LudoDB::setPassword($dbDetails['password']);
        LudoDB::setHost($dbDetails['host']);
    }

    private $successMessage;

    private function setConnectionSuccessMessage($message)
    {
        $this->successMessage = $message;
    }

    public function getOnSuccessMessageFor($service)
    {
        switch ($service) {
            case "validateConnection":
                return isset($this->successMessage) ? $this->successMessage : "Connection successful!";
            default:
                return "Installation complete. To complete the installation, create a file called
                    connection.php and insert your database details. See connection.template.php for example";
        }
    }
}
