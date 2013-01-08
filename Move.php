<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 20:52
 */
class Move extends LudoDbTable
{
    protected $config = array(
        'table' => 'Move',
        'columns' => array(
            'id' => 'int auto_increment not null primary key',
            'game_id' => 'int',
            'from' => 'varchar(10)',
            'to' => 'varchar(10)',
            'fen_id' => 'int',
            'parent_move_id' => 'int',
            'comment' => 'text'
        )
    );

    public function setFen($fen){
        $fen = new Fen($fen);
        $this->setValue('fen_id', $fen->getId());
    }

    public function setGame($id){
        $this->setValue('game_id', $id);
    }

    public function setFrom($from){
        $this->setValue('from', $from);
    }

    public function setTo($to){
        $this->setValue('to', $to);
    }
    public function setParentMove($id){
        $this->setValue('parent_move_id', $id);
    }

    public function setComment($comment){
        $this->setValue('comment', $comment);
    }

}
