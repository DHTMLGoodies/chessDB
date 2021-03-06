<?php
/**
 * LudoDB model for a chess game
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 */
class Game extends LudoDBModel implements LudoDBService
{
    protected $JSONConfig = true;

    private $reservedMetadata = array('white', 'black', 'site', 'event', 'result', 'fen', 'eco',
        'plycount', 'annotator', 'timecontrol', 'date', 'round', 'termination');

    public function setFen($fen)
    {
        $this->setValue('fen_id', Fen::getIdByFen($fen));
        $this->setValue('fen', $fen);
    }

    public function getValidServices()
    {
        return array('read', 'save', 'delete');
    }

    public function getOnSuccessMessageFor($service){
        return "";
    }

    public function getFen()
    {
        return $this->getValue('fen');
    }

    public function getFenId()
    {
        return $this->getValue('fen_id');
    }

    public function setMetadata($metadataValues)
    {
        $this->setValue('metadata', $metadataValues);
    }

    public function setDatabaseId($databaseId)
    {
        $this->setValue('database_id', $databaseId);
    }

    public function getDatabaseId()
    {
        return $this->getValue('database_id');
    }

    public function setMoves($moves)
    {
        $this->setValue('moves', $moves);
    }

    public function getMoves()
    {
        $ret = $this->getValue('moves');
        if (!isset($ret)) $ret = array();
        return $ret;
    }

    public function getMetadata()
    {
        return $this->getValue('metadata');
    }

    public function getTermination(){
        return $this->getValue('termination');
    }

    public function getPlyCount(){
        return $this->getValue('plycount');
    }

    /**
     * Return last fen position in game or start position.
     * @return String
     */
    public function getCurrentFen()
    {
        return $this->gameParser()->getFen();
    }

    private $fenParser;

    private function gameParser()
    {
        if (!isset($this->fenParser)) {
            $fen = $this->getFen();
            if (!$fen) $fen = ChessRegistry::getDefaultFen();
            $this->fenParser = new FenParser0x88($fen);
            $moves = $this->getMoves();
            foreach ($moves as $move) {
                $this->fenParser->makeMove($move);
            }
        }
        return $this->fenParser;
    }

    protected function beforeInsert()
    {
        if (!$this->getFen()) {
            $this->setFen(ChessRegistry::getDefaultFen());
        }
    }

    /**
     * Append new move to the game
     * @param $move
     * @return Array
     */
    public function appendMove($move)
    {
        if (!$this->getId()) $this->commit();
        $move = $this->gameParser()->getParsed($move);
        $move['game_id'] = $this->getId();
        $move['fen_id'] = Fen::getIdByFen($move['fen']);
        $m = new Move();
        $m->setValues($move);
        $m->commit();
        return $move;
    }

    public function validateArguments($service, $arguments)
    {
        if (count($arguments) > 1) return false;
        switch ($service) {
            case 'read':
                return count($arguments) === 1 && is_numeric($arguments[0]);
            case 'save':
                $cp = CurrentPlayer::getInstance();
                if(!$cp->hasAccessTo(ChessRoles::EDIT_GAMES) && !$cp->hasAccessTo(ChessRoles::IMPORT_GAMES)){
                    throw new LudoDBUnauthorizedException("Your are not authorized to save new games");
                }
                return count($arguments) === 0 || is_numeric($arguments[0]);

        }
        return true;
    }

    public function validateServiceData($service, $data)
    {
        return true;
    }

    public function save($data)
    {
        $data = $this->withSpecialMetadataKeysMoved($data);

        if (isset($data['white'])) $data['white_id'] = $this->getPlayerIdByName($data['white']);
        if (isset($data['black'])) $data['black_id'] = $this->getPlayerIdByName($data['black']);

        return parent::save($data);
    }

    private function withSpecialMetadataKeysMoved($data)
    {
        foreach ($this->reservedMetadata as $key) {
            if (isset($data['metadata'][$key])) {
                $data[$key] = $data['metadata'][$key];
                unset($data['metadata'][$key]);
            }
        }
        return $data;
    }

    private function getPlayerIdByName($name)
    {
        $player = new PlayerByName($name);
        if (!$player->getId()) {
            $p = new Player();
            $p->setFullName($name);
            $p->setOnlinePlayer(0);
            $p->commit();
            return $p->getId();
        }
        return $player->getId();
    }

    public function shouldCache($service)
    {
        return $service === 'read';
    }
}

