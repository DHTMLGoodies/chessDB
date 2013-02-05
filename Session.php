<?php
/**
 * Created by JetBrains PhpStorm.
 * User: borrow
 * Date: 19.12.12
 * Time: 21:20
 * To change this template use File | Settings | File Templates.
 */
class ChessSession extends LudoDBModel
{
    protected $config = array(
        'sql' => 'select * from chess_session where session_key=?',
        'table' => 'chess_session',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'session_key' => array(
                'db' => 'varchar(512)',
                'access' => 'rw'
            ),
            'user_id' => array(
                'db' => 'int',
                'access' => 'rw',
                'references' => 'chess_player(id) on delete cascade'
            ),
            'created' => array(
                'db' => 'timestamp',
                'access' => 'rw'
            ),
            'last_action' => array(
                'db' => 'datetime',
                'access' => 'rw'
            )
        ),
        'indexes' => array('session_key','user_id')
    );

    public function __construct($key = null){
        parent::__construct($key);
    }

    protected function beforeInsert(){
        $this->setValue('session_key', 'U_'.md5(microtime_float()));
    }

}
