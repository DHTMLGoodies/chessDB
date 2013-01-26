<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 20:08
 */
class Fen extends LudoDBModel
{
    protected $JSONConfig = true;

    protected function populate(){
        if(is_numeric($this->constructorValues[0])){
            $this->configParser()->setConstructBy(array('id'));
        }
        parent::populate();
        if(!$this->getId() && !is_numeric($this->constructorValues[0])){
            $this->setFen($this->constructorValues[0]);
            $this->commit();
        }
    }

    protected function getValidConstructByValue($key, $value){
        return $this->getFenForStorage($value);
    }

    private function getFenForStorage($fen){
        if(!is_numeric($fen)){
            $fen = explode(" ", $fen);
            if(count($fen)<3)$this->db->log(json_encode($this->constructorValues));
            return $fen[0]." ". $fen[1]." ". $fen[2];
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