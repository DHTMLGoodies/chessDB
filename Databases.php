<?php
/**
 * List of databases, used by Folders tree collection
 * User: Alf Magne Kalleland
 * Date: 08.02.13
 * Time: 20:55
 */
class Databases extends LudoDBCollection implements LudoDBService
{
    protected $config = array(
        "sql" => "select * from chess_database order by ID",
        "model" => "Database",
        "static" => array("type" => "database")
    );
    public function getValidServices(){
        return array('read');
    }
    public function validateService($service, $arguments){
        return count($arguments) === 0;
    }

    public function getValues(){
        return parent::getValues();
    }
}
