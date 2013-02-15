<?php
/**
 *
 * User: Alf Magne
 * Date: 05.02.13
 */
class Games extends LudoDBCollection implements LudoDBService
{
    protected $JSONConfig = true;

    public function getValidServices(){
        return array("read");
    }
    public function validateArguments($service, $arguments){
        return count($arguments) === 1 && is_numeric($arguments[0]);
    }

    public function validateServiceData($service, $data){
        return true;
    }

    public function cacheEnabledFor($service){
        return $service === "read";
    }
}
