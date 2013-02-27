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

    private function registerResult(Player $against, Player $me, $result){
        $eloMe = new Elo($me->getId(), $this->category);
        $eloOpponent = new Elo($against->getId(), $this->category);
        if($eloMe->isProvisional()){
            $this->registerProvisional($eloMe, $eloOpponent, $result);
            if($eloOpponent->isProvisional()){
                $this->registerProvisional($eloOpponent, $eloMe, $result * -1);
            }
        }else{
            $expectedScore = $this->getExpectedScore($eloMe->getElo(), $eloOpponent->getElo());
            $adjustment = $this->getKFactor($eloMe) * ($result - $expectedScore);
            $eloMe->setElo($eloMe->getElo()+ $adjustment);

            if($eloOpponent->isProvisional()){
                $this->registerProvisional($eloOpponent, $eloMe, $result * -1);
            }else{
                $blackAdjustment = ($adjustment * $this->getKFactor($eloOpponent) / $this->getKFactor($eloMe)) * -1;
                $eloOpponent->setElo($eloOpponent->getElo()+ $blackAdjustment);
            }
            // TODO blacks rating should be -1 * (White adjustment * Black K factor / White K factor)
        }
        $eloMe->commit();
        $eloOpponent->commit();
    }

    private function registerProvisional(Elo $eloMe, Elo $eloOpponent, $result){
        if($result === 0.5){
            $addition = 0;
        }else{
            $addition = ($eloOpponent->isProvisional() ? 200 : 400) * $result;
        }
        $eloMe->setElo($eloOpponent->getElo() + $addition);
    }

    private function getExpectedScore($ratingA, $ratingB){
        $qa = pow(10, $ratingA / 400);
        $qb = pow(10, $ratingB / 400);
        return $qa / ($qa + $qb);
    }

    private function getKFactor(Elo $elo){
        if($elo->getElo() > 2400)return 16;
        if($elo->getElo() >= 2100)return 24;
        return 32;
    }
}
