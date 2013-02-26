<?php

class EloSetter
{
    private $player;
    private $category;

    public function __construct(Player $player, $categoryId){
        $this->player = $player;
        $this->category = $categoryId;
    }

    public function registerWinAgainst(Player $pl){

        $eloMe = new Elo($this->player, $this->category);
        $eloOpponent = new Elo($pl->getId(), $this->category);

        if($eloMe->isProvisional()){
            $newElo = new Elo();
            $newElo->setPlayerId($this->player->getId());
            $newElo->setElo($eloOpponent->getElo() + $eloOpponent->isProvisional() ? 200 : 400);
            $newElo->commit();
        }
    }
}
