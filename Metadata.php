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
        'lookupField' => 'metadata_key',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'metadata_key' => 'varchar(255)'
        ),
        'indexes' => array('metadata_key')
    );

    public function populate($key){
        parent::populate($key);
        if(!$this->getId()){
            $this->setKey($key);
            $this->commit();
        }
    }

    public function setKey($value){
        $this->setValue('metadata_key', $value);
    }
}
