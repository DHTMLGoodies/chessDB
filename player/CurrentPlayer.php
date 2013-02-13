<?php
/**
 * Current player
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
        $me = Session::getInstance()->getUser()->getId();
        if (!$me) {
            throw new LudoDBUnauthorizedException("Your are not signed in");
        }
        $this->disableCommit();
        parent::__construct($me);
    }

    public function getValidServices()
    {
        return array_merge(parent::getValidServices(), array("games", "archive"));
    }

    public function validateArguments($service, $arguments)
    {
        return $this->getValue('id') ? count($arguments) === 0 : false;
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
}
