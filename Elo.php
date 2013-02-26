<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 26.02.13
 * Time: 22:18
 */
class Elo extends LudoDBModel
{
    protected $config = array(
        "sql" => "select * from chess_elo where player_id=? and category=? order by id desc",
        "table" => "chess_elo",
        "columns" => array(
            "id" => "int auto_increment not null primary key",
            "player_id" => array(
                "db" => "int",
                "access" => "rw",
                "references" => "chess_player(id) on delete cascade"
            ),
            "elo" => array(
                "db" => "int",
                "access" => "rw",
                "default" => 1200
            ),
            "category" => array(
                "db" => "int",
                "access" => "rw"
            ),
            "provisional" => array(
                "db" => "char(1)",
                "access" => "rw",
                "default" => 1
            )
        ),
        "indexes" => array("category", "player_id")
    );

    private $eloValues;
    public function getElo(){
        if($this->isProvisional()){
            if(!isset($eloValues)){
                $coll = new EloList($this->arguments[0], $this->arguments[1]);
                $this->eloValues = array_values($coll->getValues());
            }
            return count($this->eloValues) ? round($this->eloValues / count ($this->eloValues)) : 1200;
        }
        return $this->getValue('elo');
    }

    private function getCategory(){
        return $this->getValue('category');
    }

    public function setElo($elo){
        $this->setValue('elo', $elo);
    }

    public function getPlayerId(){
        return $this->getValue('player_id');
    }

    public function setPlayerId($playerId){
        $this->setValue('player_id', $playerId);
    }

    public function isProvisional(){
        return $this->getValue('provisional') ? true : false;
    }

    public function setCategory($id){
        $this->setValue('category', $id);
    }
}
