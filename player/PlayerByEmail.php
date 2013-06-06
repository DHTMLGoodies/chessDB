<?php
/**
 * Create Player object by username and password
 * User: Alf Magne
 * Date: 05.02.13
 */
class PlayerByEmail extends Player
{
    protected $JSONConfig = true;

    public function __construct($email){
        parent::__construct($email);
    }
}
