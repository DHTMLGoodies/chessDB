<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xait0020
 * Date: 06.02.13
 * Time: 22:19
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
    public function areValidServiceArguments($service, $arguments){
        return count($arguments) === 0;
    }
}
