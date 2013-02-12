<?php
/**
 * LudoDBModel for Chess seeks.
 */
class Seek extends LudoDBModel implements LudoDBService
{
    protected $JSONConfig = true;

    public function getValidServices(){
        return array('save');
    }

    public function validateArguments($service, $arguments){
        return count($arguments) === 0;
    }

    public function validateServiceData($service, $data){
        return true;
    }
}
