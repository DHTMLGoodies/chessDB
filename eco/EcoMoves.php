<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 06.02.13

 */
class EcoMoves extends LudoDBCollection implements LudoDBService
{
    protected $caching = true;
    protected $JSONConfig = true;

    public function __construct($fen){
        $fen = $this->getValidFen($fen);
        parent::__construct($fen);
    }

    private function getValidFen($fen){
        if(is_numeric($fen))return $fen;
        return isset($fen) ? Fen::getIdByFen(str_replace("_", "/", $fen)) : null;

    }
    public static function getValidServices(){
        return array('read');
    }
    public function areValidServiceArguments($service, $arguments){
        return count($arguments)===1;
    }
}
