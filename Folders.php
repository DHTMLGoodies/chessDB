<?php
/**
 * Chess folder collection. Lists folders and databases
 * in tree format.
 * User: Alf Magne Kalleland
 * Date: 08.02.13
 * Time: 20:55
 */
class Folders extends LudoDBTreeCollection implements LudoDBService
{

    protected $config = array(
        "sql" => "select * from chess_folder order by parent,id",
        "model" => "Folder",
        "childKey" => "children",
        "pk" => "id",
        "fk" => "parent",
        'hideForeignKeys' => true,
        "merge" => array(
            array(
                "class" => "Databases",
                "fk" => "folder_id",
                "pk" => "id"
            )
        )
    );

    public static function getValidServices(){
        return array('read');
    }

    public function validateService($service, $arguments){
        return count($arguments) === 0;
    }

    public function cacheEnabled(){
        return false;
    }
}
