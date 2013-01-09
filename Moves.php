<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne
 * Date: 09.01.13
 * Time: 12:33
 * To change this template use File | Settings | File Templates.
 */
class Moves extends LudoDbCollection
{
    protected $config = array(
        'table' => 'Move',
        'queryFields' => 'game_id',
        'columns' => array('from_square','to_square','notation','comment')
    );

    public function setMoves($moves){
        $this->deleteRecords();
        foreach($moves as $move){
            $m = new Move();
            $m->setFrom($move['from']);
            $m->setTo($move['to']);
            $m->setNotation($move['m']);
            $m->setFen($move['fen']);

            $m->setGame($this->queryValues[0]);
            $m->commit();
        }
    }
}
