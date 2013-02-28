<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 28.02.13
 * Time: 01:04
 */
class TimeControls extends LudoDBCollection implements LudoDBService
{
    protected $config = array(
        "sql" => "select * from chess_time_control where category=? order by id",
        "model" => "TimeControl"
    );

    public function getValidServices(){
        return array("read");
    }

    public function shouldCache($service){
        return false;
    }

    public function validateArguments($service, $arguments){
        return count($arguments) === 1;
    }

    public function validateServiceData($service, $data){
        return empty($data);
    }

}
