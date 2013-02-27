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
        $this->registerResult($pl, $this->player, 1);
    }

    public function registerDrawAgainst(Player $pl){
        $this->registerResult($pl, $this->player,  0.5);
    }

    public function registerLossAgainst(Player $pl){
        $this->registerResult($pl, $this->player, -1);
    }

    private function registerResult(Player $against, Player $me, $result, $firstRun = true){
        $eloMe = new Elo($me->getId(), $this->category);
        $eloOpponent = new Elo($against->getId(), $this->category);
        if($eloMe->isProvisional()){
            if($result === 0.5){
                $addition = 0;
            }else{
                $addition = ($eloOpponent->isProvisional() ? 200 : 400) * $result;
            }
            $eloMe->setElo($eloOpponent->getElo() + $addition);
        }else{
            $val = 1 / (1 + 10 * exp(($eloOpponent->getElo() - $eloMe->getElo()) / 400 ));
            $eloMe->setElo($eloMe->getElo()+ (30 * $val * $result));
        }

        if($firstRun){
            $this->registerResult($me, $against, $result*-1, false);
        }
        $eloMe->commit();

    }
}
