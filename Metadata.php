<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 20:05
 */
class Metadata extends LudoDbTable
{
    protected $config = array(
        'table' => 'Metadata',
        'queryFields' => array('metadata_key'),
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'metadata_key' => 'varchar(255)'
        ),
        'indexes' => array('metadata_key')
    );

    public function populate(){
        parent::populate();
        if(!$this->getId()){
            $this->setMetadataKey($this->queryValues[0]);
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
