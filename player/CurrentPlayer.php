<?php
/**
 * Logged on player
 * User: Alf Magne Kalleland
 * Date: 13.02.13
 * Time: 01:27
 */
class CurrentPlayer extends Player
{
    protected $JSONConfig = false;
    protected $config = array();

    public function __construct()
    {
        $myId = Session::getInstance()->getUser()->getId();
        if (!$myId) {
            throw new LudoDBUnauthorizedException("Your are not signed in");
        }
        parent::__construct($myId);
    }

    public function getValidServices(){
        return array_merge(parent::getValidServices(), array('read','save'));
    }

}
