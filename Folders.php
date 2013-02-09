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
        "childKey" => "parent",
        "pk" => "id",
        "fk" => "parent"
    );

    public static function getValidServices(){
        return array('read');
    }

    public function validateService($service, $arguments){
        return count($arguments) === 0;
    }

    public function getValues(){
        $folders = parent::getValues();
        $rows = $this->getRows();
        $db = new Databases();
        $databases = $db->getValues();
        foreach($rows as & $folder){
            if(isset($folder['id']) && isset($databases[$folder['id']])){
                $folder['children'] = $databases[$folder['id']];
            }
        }
        return $folders;
    }

    public function cacheEnabled(){
        return true;
    }
}
