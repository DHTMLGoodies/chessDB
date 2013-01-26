<?php

class Seek extends LudoDBModel
{
    protected $config = array(
        'table' => 'Seek',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'player_id' => 'int',
            'ts' => 'timestamp',
            'timeControl' => 'int'
        ),
        'join' => array(
            array('table' => 'Time_Control', 'pk' => 'id', 'fk' => 'time_control')
        ),
        'indexes' => array('player_id')
    );

}
