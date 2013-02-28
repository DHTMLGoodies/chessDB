<?php

class EloSetter
{
    private $category;

    public function __construct($categoryId){
        $this->category = $categoryId;
    }

    public function registerResult(Player $white, Player $black, $result){
        $eloWhite = new Elo($white->getId(), $this->category);
        $eloBlack = new Elo($black->getId(), $this->category);

        if($eloWhite->isProvisional()){
            $adjustment = $this->getProvisionalAdjustment($eloBlack, $result);
            $eloWhite->appendProvisional($eloBlack->getElo() + $adjustment);
        }else{
            $adjustment =  $this->getRatingAdjustmentFor($eloWhite, $eloBlack, $result);
            $eloWhite->setElo($eloWhite->getElo() + $adjustment);
        }

        $this->updateBlackElo($eloWhite, $eloBlack, $result);

        $eloWhite->commit();
        $eloBlack->commit();
    }

    private function updateBlackElo(Elo $eloWhite, Elo $eloBlack, $result){
        $e = new Elo($eloWhite->getPlayerId(), $this->category);
        if($eloBlack->isProvisional()){
            $adjustmentBlack = $this->getProvisionalAdjustment($e, $result  * -1);
            $eloBlack->appendProvisional($e->getElo() + $adjustmentBlack);
        }else{
            $adjustment =  $this->getRatingAdjustmentFor($eloWhite, $eloBlack, $result);
            $adjustmentBlack = ($adjustment * $this->getKFactor($eloBlack) / $this->getKFactor($e)) * -1;
            $eloBlack->setElo($eloBlack->getElo() + $adjustmentBlack);
        }
    }

    private function getRatingAdjustmentFor(Elo $white, Elo $against, $result){
        $expectedScore = $this->getExpectedScore($white->getElo(), $against->getElo());
        return $this->getKFactor($white) * ($result - $expectedScore);
    }

    private function getProvisionalAdjustment(Elo $eloOpponent, $result){
        if($result === 0.5){
            $addition = 0;
        }else{
            $addition = ($eloOpponent->isProvisional() ? 200 : 400) * $result;
        }
        return $addition;
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
