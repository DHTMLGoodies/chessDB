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
    private static $instance;

    public function __construct()
    {
        $myId = Session::getInstance()->getUser()->getId();
        if (!$myId) {
            throw new LudoDBUnauthorizedException("Your are not signed in");
        }
        parent::__construct($myId);
    }

    public function validateArguments($service, $arguments)
    {
        return count($arguments) === 0 || (count($arguments) === 1 && is_numeric($arguments[0]));
    }

    public function getValidServices()
    {
        return array_merge(parent::getValidServices(), array('read', 'save'));
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new CurrentPlayer();
        }
        return self::$instance;
    }

    public function read(){
        return $this->getSomeValues(array('username','email','full_name','user_access'));
    }

    public function save($values)
    {
        if(isset($values['email'])){
            unset($values['email']);
        }
        if(isset($values['user_access'])){
            unset($values['user_access']);
        }
        if ($this->passwordMismatch($values)) {
            throw new LudoDBException("Passwords does not match");
        }
        return parent::save($values);
    }

    private function passwordMismatch($values){
        return isset($values['password']) && isset($values['repeat_password']) && $values['password']
            && $values['password'] != $values['repeat_password'];
    }

    public function getOnSuccessMessageFor($service){
        switch($service){
            case "save":
                return "Changes saved successfully";
        }
        return "";
    }
}
