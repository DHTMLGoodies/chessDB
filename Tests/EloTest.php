<?php

require_once(__DIR__ . "/../autoload.php");
ini_set('display_errors','on');

class EloTest extends ChessTests
{

    /**
     * @test
     */
    public function shouldGetDefaultElo(){
        ini_set('display_errors','on');
        // given
        $user = $this->createUser('username','password');

        // when
        $elo = new Elo($user->getId(), 1);

        // then
        $this->assertEquals(1200, $elo->getElo());
    }

    /**
     * @test
     */
    public function shouldSetProvisionalEloForFirstGame(){
        // given
        $user = $this->createUser('username','password');

        // when
        $eloSetter = new EloSetter($user, 1);
        $userWithElo = $this->getUserWithElo(1500);
        $eloSetter->registerWinAgainst($userWithElo);

        $elo = new Elo($user->getId(), 1);
        $this->assertTrue($elo->isProvisional());
        // then
        $this->assertEquals(1700, $elo->getElo());
    }

    /**
     * @test
     */
    public function shouldSetProvisionalEloForConsecutiveGame(){
        // given
        $user = $this->createUser('username','password');

        // when
        $eloSetter = new EloSetter($user, 1);
        $eloSetter->registerWinAgainst($this->getUserWithElo(1500));
        $eloSetter->registerWinAgainst($this->getUserWithElo(1400));


        $elo = new Elo($user->getId(), 1);
        $this->assertTrue($elo->isProvisional());
        // then
        $this->assertEquals('1700;1600', $elo->getProvisional());
        $this->assertEquals(1650, $elo->getElo());
    }

    /**
     * @test
     */
    public function shouldSetProvisionalEloForConsecutiveGameWithLosses(){
        // given
        $user = $this->createUser('username','password');

        // when
        $eloSetter = new EloSetter($user, 1);
        $eloSetter->registerWinAgainst($this->getUserWithElo(1500));
        $eloSetter->registerWinAgainst($this->getUserWithElo(1400));
        $eloSetter->registerLossAgainst($this->getUserWithElo(1200));
        $eloSetter->registerDrawAgainst($this->getUserWithElo(2000));


        $elo = new Elo($user->getId(), 1);
        $this->assertTrue($elo->isProvisional());
        // then
        $this->assertEquals('1700;1600;1000;2000', $elo->getProvisional());
        $this->assertEquals(1575, $elo->getElo());
    }

    /**
     * @test
     */
    public function shouldSetEloForBothPlayers(){
        // given
        $player1 = $this->getUserWithElo(1500);
        $player2 = $this->getUserWithElo(2000);

        // when
        $eloSetter = new EloSetter($player1, 1);
        $eloSetter->registerWinAgainst($player2);

        $elo1 = new Elo($player1->getId(), 1);
        $elo2 = new Elo($player2->getId(), 1);

        // then
        $this->assertEquals((1500+2200)/2, $elo1->getElo());
        $this->assertEquals((2000+1300)/2, $elo2->getElo());

    }



    /**
     * @test
     */
    public function shouldDetermineWhenProvisional(){
        // given
        $user = $this->createUser('username','password');

        // when
        $elo = new Elo($user->getId(), 1);
        $this->assertFalse($elo->configParser()->isExternalColumn('elo'));
        // then
        $this->assertTrue($elo->isProvisional());
    }

    /**
     * @test
     */
    public function shouldFindEloFormula(){

        $this->assertEquals(0.686, $this->getExpectedScore(1613, 1477));
        $this->assertEquals(0.506, $this->getExpectedScore(1613, 1609));

    }

    private function getExpectedScore($ratingA, $ratingB){
        $qa = pow(10, $ratingA / 400);
        $qb = pow(10, $ratingB / 400);

        return number_format($qa / ($qa + $qb), 3);
    }

    /**
     * @test
     */
    public function shouldDetermineEloForNonProvisional(){
        // given
        $player = $this->getUserWithNonProvisionalUser();
        // when
        $elo = new Elo($player->getId(), 1);
        $elo->setElo(1400);
        $elo->commit();
        // then
        $this->assertFalse($elo->isProvisional());


        $opponent = $this->getUserWithElo(1100);
        $this->assertEquals(1400, $player->getElo(1));
        $this->assertEquals(1100, $opponent->getElo(1));

        $eloSetter = new EloSetter($player, 1);
        $eloSetter->registerWinAgainst($opponent);

        // then
        $elo = new Elo($player->getId(), 1);
        $this->assertEquals(1405, $elo->getElo());
    }

    private function getUserWithElo($eloValue, $category = 1){
        $pl = new Player();
        $pl->setUsername(uniqid('user'));
        $pl->setPassword(uniqid('pass'));
        $pl->commit();

        $elo = new Elo($pl->getId(), $category);
        $elo->setElo($eloValue);
        $elo->commit();

        return $pl;
    }

    private function getUserWithNonProvisionalUser(){
        $pl = new Player();
        $pl->setUsername(uniqid('user'));
        $pl->setPassword(uniqid('pass'));
        $pl->commit();

        $eloSetter = new EloSetter($pl, 1);
        for($i=0;$i<10;$i++){
            $eloSetter->registerWinAgainst($this->getUserWithElo(1500));
            $eloSetter->registerWinAgainst($this->getUserWithElo(1400));
            $eloSetter->registerLossAgainst($this->getUserWithElo(1200));
            $eloSetter->registerDrawAgainst($this->getUserWithElo(2000));
        }

        return $pl;

    }

}