<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 21:04
 */
class Game extends LudoDBTable
{
    protected $JSONConfig = true;

    public function setFen($fen){
        $this->setValue('fen_id', Fen::getIdByFen($fen));
    }

    public function getFen(){
        if($this->getId() && $this->getValue('fen_id')){
            return $this->getValue('fen');
        }
        return 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';
    }

    public function getFenId(){
        return $this->getValue('fen_id');
    }

    public function setMetadata($metadataValues){
        $this->setValue('metadata', $metadataValues);
    }

    public function setDatabaseId($databaseId){
        $this->setValue('database_id', $databaseId);
    }

    public function getDatabaseId(){
        return $this->getValue('database_id');
    }

    public function setMoves($moves){
        $this->setValue('moves', $moves);
    }

    public function getMoves(){
        $ret = $this->getValue('moves');
        if(!isset($ret))$ret = array();
        return $ret;
    }

    public function getCurrentFen(){
        return $this->gameParser()->getFen();
    }

    private $fenParser;
    private function gameParser(){
        if(!isset($this->fenParser)){
            $this->fenParser = new FenParser0x88($this->getFen());
            $moves = $this->getMoves();
            foreach($moves as $move){
                $this->fenParser->makeMove($move);
            }
        }
        return $this->fenParser;
    }

    public function appendMove($move){
        if(!$this->getId())$this->commit();
        $move = $this->gameParser()->getParsed($move);
        $move['game_id'] = $this->getId();
        $move['fen_id'] = Fen::getIdByFen($move['fen']);
        $m = new Move();
        $m->setValues($move);
        $m->commit();

        return $move;
    }
}
