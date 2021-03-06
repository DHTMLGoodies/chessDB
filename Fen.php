<?php
/**
 * Fen position class
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 */

class Fen extends LudoDBModel
{
    protected $JSONConfig = true;

    protected function populate(){
        parent::populate();
        if(!$this->getId() && !is_numeric($this->arguments[0])){
            $this->setFen($this->arguments[0]);
            $this->commit();
        }
    }

    protected function getValidArgument($key, $value){
        return $this->getFenForStorage($value);
    }

    private function getFenForStorage($fen){
        if(!is_numeric($fen)){
            $fen = explode(" ", $fen);
            return stripslashes($fen[0]." ". $fen[1]." ". $fen[2]);
        }
        return $fen;
    }

    public function setFen($fen){
        $this->setValue('fen', $this->getFenForStorage($fen));
    }

    public function getFen(){
        return $this->getValue('fen');
    }

    public static function getIdByFen($fen){
        $fen = new Fen($fen);
        return $fen->getId();
    }
}