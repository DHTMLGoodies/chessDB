<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 19.12.12
 * Time: 22:42
 */
class PlayerFinder extends LudoFinder
{

    public function __construct(){
        parent::__construct(new Player());
    }
    public function byUserNameAndPassword($username, $password)
    {
        return $this->where('username', $username)->where('password', md5($password))->find();
    }
}
