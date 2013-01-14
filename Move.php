<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 20:52
 */
class Move extends LudoDBTable
{
    protected $JSONConfig = true;
    protected $config = array(
        'table' => 'Move',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'game_id' => 'int',
            'notation' => 'varchar(32)',
            'from_square' => 'varchar(10)',
            'to_square' => 'varchar(10)',
            'fen_id' => 'int',
            'parent_move_id' => 'int',
            'comment' => 'text'
        ),
        'indexes' => array('game_id','fen_id')
    );

    public function setFen($fen){
        $fen = new Fen($fen);
        $this->setValue('fen_id', $fen->getId());
    }

    public function setGame($id){
        $this->setValue('game_id', $id);
    }
}
