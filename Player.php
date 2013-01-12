<?php

class Player extends LudoDBTable
{
    protected $JSONConfig = true;

    public function setPassword($password){
        $this->setValue('password', md5($password));
    }

    public function isValid(){
        $username = $this->getUsername();
        if(!$username)return false;
        $sql = "select ".$this->configParser()->getIdField()." from ". $this->configParser()->getTableName()." where username='". $this->getUsername()."'";
        if($this->getId())$sql.=" and ". $this->configParser()->getIdField()." <> '".$this->getId()."'";
        return $this->db->countRows($sql) === 0;
    }
}
