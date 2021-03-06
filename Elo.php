<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 26.02.13
 * Time: 22:18
 */
class Elo extends LudoDBModel
{

    const COUNT_PROVISIONAL = 8;

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
                "db" => "varchar(1024)",
                "access" => "rw"
            )
        ),
        "indexes" => array("category", "player_id")
    );

    public function __construct($playerId = null, $category = null){
        parent::__construct($playerId, $category);
    }

    protected function populate(){
        parent::populate();
        if(!$this->getId()){
            $this->setPlayerId($this->arguments[0]);
            $this->setCategory($this->arguments[1]);
            $this->commit();
        }
    }

    public function getElo(){
        if($this->isProvisional()){
            return $this->getProvisionalElo();
        }
        return $this->getValue('elo');
    }

    private function getProvisionalElo(){
        $eloValues = explode(";", $this->getProvisional());
        return count($eloValues ) && is_numeric($eloValues[0]) ? round(array_sum($eloValues)  / count ($eloValues )) : $this->getValue('elo');
    }

    public function setElo($elo){
        if($this->isProvisional()){
            $this->appendProvisional($elo);
            $elo = $this->getProvisionalElo();
        }
        $this->setValue('elo', max(1015, $elo));
    }

    public function appendProvisional($elo){
        $pr = $this->getProvisional();
        $this->setValue('provisional', $pr ? $pr .";". $elo : $elo);
    }

    public function getProvisional(){
        $ret = $this->getValue('provisional');
        return isset($ret) ? $ret : '';
    }

    public function getPlayerId(){
        return $this->getValue('player_id');
    }

    public function setPlayerId($playerId){
        $this->setValue('player_id', $playerId);
    }

    public function isProvisional(){
        return count(explode(";", $this->getValue('provisional'))) < self::COUNT_PROVISIONAL;
    }

    public function setCategory($id){
        $this->setValue('category', $id);
    }
}
