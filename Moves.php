<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne
 * Date: 09.01.13
 * Time: 12:33
 * To change this template use File | Settings | File Templates.
 */
class Moves extends LudoDBCollection
{
    protected $config = array(
        'table' => 'Move',
        'constructorParams' => 'game_id',
        'columns' => array('from_square','to_square','notation','comment')
    );

    public function setMoves($moves){
        $this->deleteRecords();
        foreach($moves as $move){
            $m = new Move();
            if(isset($move['from']))$m->setFrom($move['from']);
            if(isset($move['to']))$m->setTo($move['to']);
            if(isset($move['m']))$m->setNotation($move['m']);
            if(isset($move['fen']))$m->setFen($move['fen']);
            if(isset($move['comment']))$m->setComment($move['comment']);

            $m->setGame($this->constructorValues[0]);
            $m->commit();
        }
    }
}
