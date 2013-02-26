<?php

require_once(__DIR__ . "/../autoload.php");

class EloTest extends ChessTests
{

    /**
     * @test
     */
    public function shouldGetDefaultElo(){
        LudoDB::enableSqlLogging();
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
        ini_set('display_errors','on');
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
        $pl->setUsername('dummy');
        $pl->setPassword('dummy2');
        $pl->commit();

        $elo = new Elo($pl->getId(), $category);
        $elo->setElo($eloValue);
        $elo->commit();

        return $pl;
    }

}