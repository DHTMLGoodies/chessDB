<?php
/**
 * LudoDBModel for chess player objects
 */

class Player extends LudoDBModel implements LudoDBService
{
    protected $JSONConfig = true;

    public function setPassword($password)
    {
        $this->setValue('password', md5($password));
    }

    public function getFullName()
    {
        if ($this->getId()) {
            return $this->getValue('full_name');
        }
        return null;
    }

    public function getUserAccess(){
        return $this->getValue('user_access');
    }

    public function setUserAccess($access){
        $this->setValue('user_access', $access);
    }

    public function isValid()
    {
        if(!$this->getValue('online_player'))return true;
        $username = $this->getUsername();
        if (!$username) return false;
        $sql = "select " . $this->parser->getIdField() . " from " . $this->parser->getTableName() . " where username='" . $this->getUsername() . "'";
        if ($this->getId()) $sql .= " and " . $this->parser->getIdField() . " <> '" . $this->getId() . "'";
        return $this->db->countRows($sql) === 0;
    }

    public function setUsername($username){
        $this->setValue('username', $username);
    }

    public function getUsername(){
        return $this->getValue('username');
    }

    public function setFullName($name){
        $this->setValue('full_name', $name);
    }


    public function games()
    {
        $obj = new PlayerGames($this->getId(), '0');
        return $obj->getValues();
    }

    public function archive()
    {
        $obj = new PlayerGames($this->getId(), '1');
        return $obj->getValues();
    }

    public function setOnlinePlayer($online){
        $this->setValue('online_player', $online);
    }

    public function gravatar()
    {
        $size = 80;
        $default = "";
        if(!$this->getValue('email'))return "";
        return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->getValue('email') ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
        /*
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }
        return $url;
        */
    }

    public function getPassword(){
        return $this->getValue('password');
    }

    public function seeks(){
        $seeks = new Seeks($this->getId());
        return $seeks->getValues();
    }

    public function getValidServices(){
        return array("gravatar", "seeks", "games", "archive", "register");
    }



    public function validateArguments($service, $arguments){
        switch($service){
            case 'read':
                return count($arguments) === 1;
            case "register":
                return count($arguments) < 2;
            default:
        }
        return count($arguments) === 1;
    }

    public function validateServiceData($service, $data){
        switch($service){
            case "register":
                if(!isset($data['username']) || !isset($data['email']) || !isset($data['password']) || !isset($data['repeat_password'])){
                    throw new LudoDBException("Missing user data");
                }
                if($this->hasRowWith(array("email" => $data["email"]))){
                    throw new LudoDBException("Invalid email address");
                }
                if($this->hasRowWith(array("username" => $data["username"]))){
                    throw new LudoDBException("Invalid user name");
                }
                if($data['password'] != $data['repeat_password']){
                    throw new LudoDBException("Password does not match");
                }

        }
        return true;
    }

    public function shouldCache($service){
        return false;
    }


    public function register($userDetails){
        $this->setDefaultValuesForNewPlayers();
        $ret = $this->setValues($userDetails);
        $this->commit();

        $session = new Session();
        $session->signIn(array("username" => $this->getUsername(),"password" => $this->getPassword()));

        return array_merge($ret, array('token' => $session->getKey()));
    }

    private function setDefaultValuesForNewPlayers(){
        $this->setOnlinePlayer(1);
        $this->setUserAccess(1);
    }
}
