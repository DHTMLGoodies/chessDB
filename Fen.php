<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 20:08
 */
class Fen extends LudoDbTable
{
    protected $config = array(
        'table' => 'Fen',
        'idField' => 'id',
        'queryFields' => 'fen',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'fen' => 'varchar(128)'
        ),
        'indexes' => array('fen')
    );

    public function populate(){
        if(is_numeric($this->queryValues[0])){
            $this->config['queryFields'] = 'id';
        }
        parent::populate();
        if(!$this->getId() && !is_numeric($this->queryValues[0])){
            $this->setFen($this->queryValues[0]);
            $this->commit();
        }
    }

    protected function getValidQueryParam($key, $value){
        return $this->getFenForStorage($value);
    }

    private function getFenForStorage($fen){
        if(!is_numeric($fen)){
            $fen = explode(" ", $fen);
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
}