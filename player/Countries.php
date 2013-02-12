<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 06.02.13
 */
class Countries extends LudoDBCollection implements LudoDBService
{
    protected $enableCaching = true;
    protected $config = array(
        "sql" => "select * from country order by name"
    );

    public function getValidServices(){
        return array('read');
    }
    public function validateArguments($service, $arguments){
        return count($arguments) === 0;
    }

    public function validateServiceData($service, $data){
        return true;
    }
}
