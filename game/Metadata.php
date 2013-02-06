<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 20:05
 */
class Metadata extends LudoDBModel
{
    protected $JSONConfig = true;

    public function populate(){
        parent::populate();
        if(!$this->getId()){
            $this->setMetadataKey($this->arguments[0]);
            $this->commit();
        }
    }

    public function setMetadataKey($value){
        $this->setValue('metadata_key', $value);
    }

    public function getMetadataKey(){
        return $this->getValue('metadata_key');
    }
}
