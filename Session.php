<?php
/**
 * LudoDBModel for Sessions
 * User: borrow
 * Date: 19.12.12
 */
class Session extends LudoDBModel
{
    protected $config = array(
        'sql' => 'select * from chess_session where session_key=? and logged_out IS NULL',
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
            ),
            'logged_out' => array(
                'db' => 'char(1)',
                'access' => 'rw'
            )
        ),
        'indexes' => array('session_key','user_id')
    );

    public function __construct($key = null){
        parent::__construct($key);
    }

    protected function beforeInsert(){
        $this->setValue('session_key', 'U_'.md5(microtime(true)));
    }

    public function setUserId($id){
        $this->setValue('user_id', $id);
    }

    public function getKey(){
        return $this->getValue('session_key');
    }

}
