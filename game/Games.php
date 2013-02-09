<?php
/**
 *
 * User: Alf Magne
 * Date: 05.02.13
 */
class Games extends LudoDBCollection implements LudoDBService
{
    protected $JSONConfig = true;

    public static function getValidServices(){
        return array("read");
    }
    public function validateService($service, $arguments){
        return count($arguments) === 1 && is_numeric($arguments[0]);
    }

    public function cacheEnabled(){
        return true;
    }
}