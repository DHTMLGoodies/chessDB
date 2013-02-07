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

    public static function getValidServices(){
        return array('read');
    }
    public function validateService($service, $arguments){
        return count($arguments) === 0;
    }
}
