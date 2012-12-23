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
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'metadata_key' => 'varchar(255)'
        )
    );
}
