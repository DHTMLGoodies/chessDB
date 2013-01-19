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
        $this->addLineOfMoves($moves);
    }

    private function addLineOfMoves($moves, $parentId = 0){
        foreach($moves as $move){
            $id = $this->addMove($move, $parentId);
            if(isset($move['variations'])){
                foreach($move['variations'] as $variation){
                    $this->addLineOfMoves($variation, $id);
                }
            }
        }
    }

    private function addMove($move, $parentId = 0){
        $m = new Move();
        $m->setValues($move);
        if(isset($move['fen']))$m->setFen($move['fen']);
        $m->setGame($this->constructorValues[0]);
        $m->setParentMoveId($parentId);
        $m->commit();
        return $m->getId();
    }

    /**
     * @param LudoDBTable $model
     * @param array $columns
     * @return array
     */
    protected function getValuesFromModel($model, $columns){
        return $model->getSomeValuesFiltered($columns);
    }
}
