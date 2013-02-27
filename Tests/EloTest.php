<?php

require_once(__DIR__ . "/../autoload.php");

class EloTest extends ChessTests
{

    /**
     * @test
     */
    public function shouldGetDefaultElo(){
        LudoDB::enableSqlLogging();
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

}