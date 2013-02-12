<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 06.02.13

 */
class EcoMoves extends LudoDBCollection implements LudoDBService
{
    protected $JSONConfig = true;

    public function __construct($fen){
        $fen = $this->getValidFen($fen);
        parent::__construct($fen);
    }

    private function getValidFen($fen){
        if(is_numeric($fen))return $fen;
        return isset($fen) ? Fen::getIdByFen(str_replace("_", "/", $fen)) : null;

    }
    public function getValidServices(){
        return array('read');
    }
    public function validateService($service, $arguments){
        return count($arguments)===1;
    }

    public function cacheEnabled(){
        return true;
    }
}
