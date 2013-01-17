<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 21:04
 */
class Game extends LudoDBTable
{
    protected $JSONConfig = true;
    protected $config = array(
        'table' => 'Game',
        'constructBy' => 'id',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'fen_id' => 'int',
            'fen' => array(
                'class' => 'Fen',
                'get' => 'getFen',
                'fk' => 'fen_id'
            ),
            'database_id' => 'int',
            'created_by' => 'int',
            'creator' => array(
                'class' => 'Player',
                'fk' => 'created_by',
                'method' => 'getFullName'
            ),
            'metadata' => array(
                'class' => 'MetadataCollection',
                'set' => 'setMetadata'
            ),
            'moves' => array(
                'class' => 'Moves',
                'set' => 'setMoves'
            )
        )
    );

    public function setFen($fen){
        $fenObj = new Fen($fen);
        $this->setValue('fen_id', $fenObj->getId());
    }

    public function getFen(){
        return $this->getValue('fen');
    }

    public function getFenId(){
        return $this->getValue('fen_id');
    }

    public function setMetadata($metadataValues){
        $this->setValue('metadata', $metadataValues);
    }

    public function setDatabaseId($databaseId){
        $this->setValue('database_id', $databaseId);
    }

    public function getDatabaseId(){
        return $this->getValue('database_id');
    }

    public function setMoves($moves){
        $this->setValue('moves', $moves);
    }
}
