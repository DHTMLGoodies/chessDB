<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 19.12.12
 * Time: 22:42
 */
class PlayerFinder
{
    public function byUserNameAndPassword($username, $password)
    {
        $player = new Player();
        return $player->where('username')->equals($username)->where('password')->equals(md5($password))->create();
    }
}
