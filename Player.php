<?php

class Player extends LudoDBModel
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

    function getGravatar($email, $size = 80, $default = "")
    {
        return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
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
}
