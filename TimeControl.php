<?php

class TimeControl extends LudoDbTable
{
    protected $tableName = 'Time_Control';
    protected $config = array(
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'increment' => 'int',
            'time' => 'int'
        )
    );
}
