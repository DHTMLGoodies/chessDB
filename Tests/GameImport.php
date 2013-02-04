<?php
/**
 * LudoDB model for game import
 * User: Alf Magne Kalleland
 * Date: 04.02.13
 * Time: 22:40
 */
class GameImport implements LudoDBService
{
    public static $validServices = array('save');

    public function __construct(){

    }

    public function save($request){
        $ret = array();
        $filePath = $this->getFilePath($request);
        if(!file_exists($filePath)){
            throw new Exception("File not found $filePath", 400);
        }
        $parser = new PgnParser($filePath);
        $games = $parser->getGames();
        foreach($games as $game){
            $ret[] = $this->importGame($game, $request['databaseId']);
        }
        return $ret;
    }

    private function getFilePath($request){
        return $request['file'];
    }

    private function importGame($game, $intoDb = null){
        $game['database_id'] = $intoDb;
        $g = new Game();
        $g->save($game);
        return $g->getId();
    }

    public function areValidServiceArguments($service, $args){
        return true;
    }
}
