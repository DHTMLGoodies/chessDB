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
            return $this->getValue('firstname') . " " . $this->getValue('lastname');
        }
        return null;
    }

    public function getAccess(){
        return $this->getValue('user_access');
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

    private function getUsername(){
        return $this->getValue('username');
    }

    public function setFullName($name){
        $this->setValue('full_name', $name);
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

    public function seeks(){
        $seeks = new Seeks($this->getId());
        return $seeks->getValues();
    }

    public function getValidServices(){
        return array("gravatar", "seeks");
    }

    public function validateArguments($service, $arguments){
        return count($arguments) === 1;
    }

    public function validateServiceData($service, $data){
        return true;
    }

    public function cacheEnabled(){
        return false;
    }
}
