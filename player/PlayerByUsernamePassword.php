<?php
/**
 * Create Player object by username and password
 * User: Alf Magne
 * Date: 05.02.13
 */
class PlayerByUsernamePassword extends Player
{
    protected $JSONConfig = true;

    public function __construct($username, $password){
        $password = md5($password);
        parent::__construct($username, $password);
    }
}
