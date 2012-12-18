<?php

class Player extends LudoDbTable
{
    protected $tableName = 'Player';
    protected $config = array(
        'columns' => array(
            'id' => 'int auto_increment not null primary key'

        )
    );
}
