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
    protected $JSONConfig = true;

    public function setMoves($moves){
        $this->deleteRecords();
        foreach($moves as $move){
            $m = new Move();
            $m->setValues($move);
            if(isset($move['fen']))$m->setFen($move['fen']);
            $m->setGame($this->constructorValues[0]);
            $m->commit();
        }
    }
}
