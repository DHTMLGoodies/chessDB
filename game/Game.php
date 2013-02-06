<?php
/**
 * LudoDB model for a chess game
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 21:04
 */
class Game extends LudoDBModel implements LudoDBService
{
    protected $JSONConfig = true;
    protected $caching = true;
    private $defaultFen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

    public function setFen($fen){
        $this->setValue('fen_id', Fen::getIdByFen($fen));
        $this->setValue('fen', $fen);
    }

    public static function getValidServices(){
        return array('read','save','delete');
    }

    public function getFen(){
        return $this->getValue('fen');
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

    public function getMetadata(){
        return $this->getValue('metadata');
    }

    /**
     * Return last fen position in game or start position.
     * @return String
     */
    public function getCurrentFen(){
        return $this->gameParser()->getFen();
    }

    private $fenParser;
    private function gameParser(){
        if(!isset($this->fenParser)){
            $fen = $this->getFen();
            if(!$fen)$fen = $this->defaultFen;
            $this->fenParser = new FenParser0x88($fen);
            $moves = $this->getMoves();
            foreach($moves as $move){
                $this->fenParser->makeMove($move);
            }
        }
        return $this->fenParser;
    }

    protected function beforeInsert(){
        if(!$this->getFen()){
            $this->setFen($this->defaultFen);
        }
    }

    /**
     * Append new move to the game
     * @param $move
     * @return Array
     */
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

    public function areValidServiceArguments($service, $arguments){
        if(count($arguments)>1)return false;
        switch($service){
            case 'read':
                return count($arguments) === 1 && is_numeric($arguments[0]);
            case 'save':
                return count($arguments) === 0 || is_numeric($arguments[0]);

        }
        return true;
    }

    public function save($data){

        $data = $this->withSpecialMetadataKeysMoved($data);

        if(isset($data['white']))$data['white_id'] = $this->getPlayerIdByName($data['white']);
        if(isset($data['black']))$data['black_id'] = $this->getPlayerIdByName($data['black']);

        return parent::save($data);
    }

    private function withSpecialMetadataKeysMoved($data){
        $keys = array('white','black','site','event','result','fen','eco',
            'plycount','annotator','timecontrol','date','round','termination');
        foreach($keys as $key){
            if(isset($data['metadata'][$key])){
                $data[$key] = $data['metadata'][$key];
                unset($data['metadata'][$key]);
            }
        }
        return $data;
    }

    private function getPlayerIdByName($name){
        $player = new PlayerByName($name);
        if(!$player->getId()){
            $p = new Player();
            $p->setFullName($name);
            $p->setOnlinePlayer(0);
            $p->commit();
            return $p->getId();
        }
        return null;
    }
}
