<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 08.01.13
 * Time: 08:59
 */
class MetadataValue extends LudoDbTable
{
    protected $config = array(
        'table' => 'Metadata_Value',
        'lookupField' => 'metadata_id',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'game_id' => 'int',
            'metadata_value' => 'varchar(4000)',
            'metadata_id' => 'int'
        ),
        'indexes' => array('game_id','metadata_id')
    );

    protected function populate($id){
        if(!is_numeric($id)){
            $m = new Metadata($id);
            $id = $m->getId();
        }
        parent::populate($id);
    }

    public function setMetadataKey($key){
        $m = new Metadata($key);
        $this->setValue('metadata_id', $m->getId());
    }

    public function setMetadataValue($value){
        $this->setValue('metadata_value', $value);
    }

    public function setGameId($gameId){
        $this->setValue('game_id', $gameId);
    }

    public function getGameId(){
        return $this->getValue('game_id');
    }

    public function getMetadataId(){
        return $this->getValue('metadata_id');
    }

    public function getMetadataKey(){
        $m = new Metadata($this->getMetadataId());
        return $m->getMetadataKey();
    }

    public function getMetadataValue(){
        return $this->getValue('metadata_value');
    }
}
