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
        "sql" => "select * from chess_folder order by parent,sort,id",
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

    public function getValidServices(){
        return array('read');
    }

    public function getOnSuccessMessageFor($service){
        return "";
    }

    public function validateArguments($service, $arguments){
        return count($arguments) === 0;
    }

    public function validateServiceData($service, $arguments){
        return true;
    }

    public function cacheEnabledFor($service){
        return false;
    }
}
