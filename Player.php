<?php

class Player extends LudoDbTable
{
    protected $tableName = 'Player';
    protected $config = array(
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'username' => 'varchar(64) unique',
            'email' => 'varchar(512)',
            'password' => 'varchar(32)',
            'online_player' => 'char(1)',
            'country' => 'int',
            'active' => 'int',
            'user_access' => 'int'
        ),
        'indexes' => array('country','active','online_player')
    );

    public function setUsername($username){
        $this->setValue('username', $username);
    }
    public function getUsername(){
        return $this->getValue('username');
    }

    public function getPassword(){
        return $this->getValue('password');
    }

    public function setPassword($password){
        $this->setValue('password', md5($password));
    }

    public function isValid(){
        $username = $this->getUsername();
        if(!$username)return false;
        $sql = "select ".$this->idField." from ". $this->getTableName()." where username='". $this->getUsername()."'";
        if($this->getId())$sql.=" and ". $this->idField." <> '".$this->getId()."'";
        return $this->db->countRows($sql) === 0;
    }
}
