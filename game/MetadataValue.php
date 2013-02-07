<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 08.01.13

 */
class MetadataValue extends LudoDBModel
{
    protected $JSONConfig = true;

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
