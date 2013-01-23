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

    public function setFen($fen){
        $fen = new Fen($fen);
        $this->setValue('fen_id', $fen->getId());
    }

    public function setGame($id){
        $this->setValue('game_id', $id);
    }

    public function setParentMoveId($id){
        $this->setValue('parent_move_id', $id);
    }

    public function startVariation(){
        $this->setValue('start_variation', '1');
    }
    public function endVariation(){
        $this->setValue('end_variation', '1');
    }
}
