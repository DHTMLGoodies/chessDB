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
            $expectedScore = $this->getExpectedScore($eloMe->getElo(), $eloOpponent->getElo());
            $val = $this->getKFactor($eloMe) * ($result - $expectedScore);
            #$val = $expectedScore * ($this->getKFactor($eloMe) * $result);
            /*
            $scoreDiff = $eloMe->getElo() - $eloOpponent->getElo();
            $dividend = 10 * exp( ($scoreDiff / $this->getFFactor($eloOpponent)) + 1 );
            $val = $this->getKFactor($eloMe) * ($result - (1 / $dividend));
            */
            $eloMe->setElo($eloMe->getElo()+ $val);
        }

        if($firstRun){
            $this->registerResult($me, $against, $result*-1, false);
        }
        $eloMe->commit();
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
