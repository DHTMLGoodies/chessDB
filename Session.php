<?php
/**
 * Created by JetBrains PhpStorm.
 * User: borrow
 * Date: 19.12.12
 * Time: 21:20
 * To change this template use File | Settings | File Templates.
 */
class Session extends LudoDbTable
{
    protected $config = array(
        'table' => 'Session',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'session_key' => 'varchar(512)',
            'user_id' => 'int',
            'created' => 'timestamp',
            'last_action' => 'datetime'
        ),
        'indexes' => array('session_key','user_id')
    );

    protected function beforeInsert(){
        $this->setValue('session_key', 'U_'.md5(microtime_float()));
    }

}
