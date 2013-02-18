<?php
/**
 * LudoDB model for game import
 * User: Alf Magne Kalleland
 * Date: 04.02.13
 */
class GameImport implements LudoDBService
{
    private $fileArg;
    private $databaseArg;
    public function __construct($file = null, $databaseArg = null){
        if(isset($file)){
            $this->fileArg = $file;
        }
        if(isset($databaseArg)){
            $this->databaseArg = $databaseArg;
        }
    }

    public function getValidServices(){
        return array('import');
    }

    public function getOnSuccessMessageFor($service){
        return "";
    }

    public function import($request){
        $ret = array();
        $filePath = $this->getFilePath($request);
        if(!file_exists($filePath)){
            throw new Exception("File not found $filePath", 400);
        }
        $parser = new PgnParser($filePath);
        $games = $parser->getGames();
        foreach($games as $game){
            $ret[] = $this->importGame($game, $this->getDatabaseId($request));
        }
        return $ret;
    }

    private function getFilePath($request){
        return isset($request['file']) ? $request['file'] : ChessRegistry::getPgnFolder().$this->fileArg.".pgn";
    }

    private function getDatabaseId($request){
        return isset($request['databaseId']) ? $request['databaseId'] : $this->databaseArg;
    }

    private function importGame($game, $intoDb = null){
        $game['database_id'] = $intoDb;
        $g = new Game();
        $g->save($game);
        return $g->getId();
    }

    public function validateArguments($service, $args){
        return true;
    }

    public function validateServiceData($service, $data){
        return true;
    }

    public function shouldCache($service){
        return false;
    }

}
