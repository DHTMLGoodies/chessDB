<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 21:04
 */
class Game extends LudoDbTable
{
    protected $config = array(
        'table' => 'Game',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
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
                'fk' => 'id'
            )
        )
    );

    public function setMetadata($metadataValues){

    }
}
