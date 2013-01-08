<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 08.01.13
 * Time: 10:40
 */
class MetadataCollection extends LudoDbCollection
{
    protected $config = array(
        'table' => 'Metadata_Value',
        'lookupField' => 'game_id',
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
        foreach($metadataValues as $key=>$value){
            $m = new MetadataValue($key);
            $m->setMetadataKey($key);
            $m->setMetadataValue($value);
            $m->setGameId($this->lookupValue);
            $m->commit();
        }
    }
}
