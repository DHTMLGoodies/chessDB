<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 08.01.13
 * Time: 10:40
 */
class MetadataCollection extends LudoDBCollection
{
    protected $config = array(
        'model' => 'MetadataValue',
        'constructBy' => 'game_id',
        'columns' => array('metadata_value'),
        'join' => array(
            array(
                'table' => 'Metadata',
                'columns' => array('metadata_key'),
                'pk' => 'id',
                'fk' => 'metadata_id')
        )

    );

    public function getValues(){
        $ret = array();
        foreach($this as $value){
            if(isset($value['metadata_value'])){
                $ret[$value['metadata_key']] = $value['metadata_value'];
            }
        }
        return $ret;
    }

    public function setMetadata($metadataValues){
        $this->deleteRecords();
        foreach($metadataValues as $key=>$value){
            $m = new MetadataValue($this->constructorValues[0], $key);
            $m->setMetadataKey($key);
            $m->setMetadataValue($value);
            $m->setGameId($this->constructorValues[0]);
            $m->commit();
        }
    }
}
