<?php

class TimeControl extends LudoDBTable
{
    protected $config = array(
        'table' => 'Time_Control',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'increment' => 'int default 0',
            'time' => 'int',
            'correspondence' => 'char(1)',
            'add_time_on' => 'int',
            'time_to_add' => 'int'
        ),
        'data' => array(
            array('time' => 5),
            array('time' => 10),
            array('time' => 15),
            array('time' => 30),
            array('time' => 45),
            array('time' => 90),
            array('time' => 90, 'increment' => 30),
            array('time' => 120),
            array('time' => '1', 'correspondence' => '1'),
            array('time' => '2', 'correspondence' => '1'),
            array('time' => '3', 'correspondence' => '1'),
            array('time' => '4', 'correspondence' => '1'),
            array('time' => '5', 'correspondence' => '1'),
            array('time' => '6', 'correspondence' => '1'),
            array('time' => '7', 'correspondence' => '1'),
            array('time' => '8', 'correspondence' => '1'),
            array('time' => '9', 'correspondence' => '1'),
            array('time' => '10', 'correspondence' => '1'),
            array('time' => '11', 'correspondence' => '1'),
            array('time' => '12', 'correspondence' => '1'),
            array('time' => '13', 'correspondence' => '1'),
            array('time' => '14', 'correspondence' => '1'),
        )
    );
}
