<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne
 * Date: 09.01.13
 * Time: 12:29
 * To change this template use File | Settings | File Templates.
 */

require_once("autoload.php");
require_once("../parser/Board0x88Config.php");
require_once("../parser/FenParser0x88.php");
require_once("../Profiling.php");
ini_set('display_errors','on');

$gameJSON = '{
            "fen":"rnbqkbnr\/pppppppp\/8\/8\/8\/8\/PPPPPPPP\/RNBQKBNR w KQkq - 0 1",
            "metadata":
            {
                "event":"London olm",
                "site":"London",
                "date":"1927.??.??",
                "round":"?",
                "white":"Nimzowitsch, Aaron ",
                "black":"Romi, Massimiliano",
                "result":"1-0",
                "whiteelo":"",
                "blackelo":"",
                "eco":"D35",
                "castle":1
            },
            "moves":[
                {"m":"d4","from":"d2","to":"d4","fen":"rnbqkbnr\/pppppppp\/8\/8\/3P4\/8\/PPP1PPPP\/RNBQKBNR b KQkq - 0 1","comment": "Typical first move"},
                {"m":"d5","from":"d7","to":"d5","fen":"rnbqkbnr\/ppp1pppp\/8\/3p4\/3P4\/8\/PPP1PPPP\/RNBQKBNR w KQkq - 0 2"},
                {"m":"c4","from":"c2","to":"c4","fen":"rnbqkbnr\/ppp1pppp\/8\/3p4\/2PP4\/8\/PP2PPPP\/RNBQKBNR b KQkq c3 0 2"},
                {"m":"e6","from":"e7","to":"e6","fen":"rnbqkbnr\/ppp2ppp\/4p3\/3p4\/2PP4\/8\/PP2PPPP\/RNBQKBNR w KQkq - 0 3"},
                {"m":"Nc3","from":"b1","to":"c3","fen":"rnbqkbnr\/ppp2ppp\/4p3\/3p4\/2PP4\/2N5\/PP2PPPP\/R1BQKBNR b KQkq - 1 3"},
                {"m":"Nf6","from":"g8","to":"f6","fen":"rnbqkb1r\/ppp2ppp\/4pn2\/3p4\/2PP4\/2N5\/PP2PPPP\/R1BQKBNR w KQkq - 2 4"},
                {"m":"Bg5","from":"c1","to":"g5","fen":"rnbqkb1r\/ppp2ppp\/4pn2\/3p2B1\/2PP4\/2N5\/PP2PPPP\/R2QKBNR b KQkq - 3 4"},
                {"m":"Nbd7","from":"b8","to":"d7","fen":"r1bqkb1r\/pppn1ppp\/4pn2\/3p2B1\/2PP4\/2N5\/PP2PPPP\/R2QKBNR w KQkq - 4 5"},
                {"m":"e3","from":"e2","to":"e3","fen":"r1bqkb1r\/pppn1ppp\/4pn2\/3p2B1\/2PP4\/2N1P3\/PP3PPP\/R2QKBNR b KQkq - 0 5"},
                {"m":"c6","from":"c7","to":"c6","fen":"r1bqkb1r\/pp1n1ppp\/2p1pn2\/3p2B1\/2PP4\/2N1P3\/PP3PPP\/R2QKBNR w KQkq - 0 6"},
                {"m":"cxd5","from":"c4","to":"d5","fen":"r1bqkb1r\/pp1n1ppp\/2p1pn2\/3P2B1\/3P4\/2N1P3\/PP3PPP\/R2QKBNR b KQkq - 0 6"},
                {"m":"exd5","from":"e6","to":"d5","fen":"r1bqkb1r\/pp1n1ppp\/2p2n2\/3p2B1\/3P4\/2N1P3\/PP3PPP\/R2QKBNR w KQkq - 0 7"},
                {"m":"Bd3","from":"f1","to":"d3","fen":"r1bqkb1r\/pp1n1ppp\/2p2n2\/3p2B1\/3P4\/2NBP3\/PP3PPP\/R2QK1NR b KQkq - 1 7"},
                {"m":"Bd6","from":"f8","to":"d6","fen":"r1bqk2r\/pp1n1ppp\/2pb1n2\/3p2B1\/3P4\/2NBP3\/PP3PPP\/R2QK1NR w KQkq - 2 8"},
                {"m":"Qc2","from":"d1","to":"c2","fen":"r1bqk2r\/pp1n1ppp\/2pb1n2\/3p2B1\/3P4\/2NBP3\/PPQ2PPP\/R3K1NR b KQkq - 3 8"},
                {"m":"h6","from":"h7","to":"h6","fen":"r1bqk2r\/pp1n1pp1\/2pb1n1p\/3p2B1\/3P4\/2NBP3\/PPQ2PPP\/R3K1NR w KQkq - 0 9"},
                {"m":"Bh4","from":"g5","to":"h4","fen":"r1bqk2r\/pp1n1pp1\/2pb1n1p\/3p4\/3P3B\/2NBP3\/PPQ2PPP\/R3K1NR b KQkq - 1 9"},
                {"m":"Qa5","from":"d8","to":"a5","fen":"r1b1k2r\/pp1n1pp1\/2pb1n1p\/q2p4\/3P3B\/2NBP3\/PPQ2PPP\/R3K1NR w KQkq - 2 10"},
                {"m":"O-O-O","from":"e1","to":"c1","fen":"r1b1k2r\/pp1n1pp1\/2pb1n1p\/q2p4\/3P3B\/2NBP3\/PPQ2PPP\/2KR2NR b kq - 3 10"},
                {"m":"Bb4","from":"d6","to":"b4","fen":"r1b1k2r\/pp1n1pp1\/2p2n1p\/q2p4\/1b1P3B\/2NBP3\/PPQ2PPP\/2KR2NR w kq - 4 11"},
                {"m":"Nge2","from":"g1","to":"e2","fen":"r1b1k2r\/pp1n1pp1\/2p2n1p\/q2p4\/1b1P3B\/2NBP3\/PPQ1NPPP\/2KR3R b kq - 5 11"},
                {"m":"Be7","from":"b4","to":"e7","fen":"r1b1k2r\/pp1nbpp1\/2p2n1p\/q2p4\/3P3B\/2NBP3\/PPQ1NPPP\/2KR3R w kq - 6 12"},
                {"m":"Kb1","from":"c1","to":"b1","fen":"r1b1k2r\/pp1nbpp1\/2p2n1p\/q2p4\/3P3B\/2NBP3\/PPQ1NPPP\/1K1R3R b kq - 7 12"},
                {"m":"Nf8","from":"d7","to":"f8","fen":"r1b1kn1r\/pp2bpp1\/2p2n1p\/q2p4\/3P3B\/2NBP3\/PPQ1NPPP\/1K1R3R w kq - 8 13"},
                {"m":"h3","from":"h2","to":"h3","fen":"r1b1kn1r\/pp2bpp1\/2p2n1p\/q2p4\/3P3B\/2NBP2P\/PPQ1NPP1\/1K1R3R b kq - 0 13"},
                {"m":"Be6","from":"c8","to":"e6","fen":"r3kn1r\/pp2bpp1\/2p1bn1p\/q2p4\/3P3B\/2NBP2P\/PPQ1NPP1\/1K1R3R w kq - 1 14"},
                {"m":"f3","from":"f2","to":"f3","fen":"r3kn1r\/pp2bpp1\/2p1bn1p\/q2p4\/3P3B\/2NBPP1P\/PPQ1N1P1\/1K1R3R b kq - 0 14"},
                {"m":"a6","from":"a7","to":"a6","fen":"r3kn1r\/1p2bpp1\/p1p1bn1p\/q2p4\/3P3B\/2NBPP1P\/PPQ1N1P1\/1K1R3R w kq - 0 15"},
                {"m":"a3","from":"a2","to":"a3","fen":"r3kn1r\/1p2bpp1\/p1p1bn1p\/q2p4\/3P3B\/P1NBPP1P\/1PQ1N1P1\/1K1R3R b kq - 0 15"},
                {"m":"Bd7","from":"e6","to":"d7","fen":"r3kn1r\/1p1bbpp1\/p1p2n1p\/q2p4\/3P3B\/P1NBPP1P\/1PQ1N1P1\/1K1R3R w kq - 1 16"},
                {"m":"Bxf6","from":"h4","to":"f6","fen":"r3kn1r\/1p1bbpp1\/p1p2B1p\/q2p4\/3P4\/P1NBPP1P\/1PQ1N1P1\/1K1R3R b kq - 0 16"},
                {"m":"Bxf6","from":"e7","to":"f6","fen":"r3kn1r\/1p1b1pp1\/p1p2b1p\/q2p4\/3P4\/P1NBPP1P\/1PQ1N1P1\/1K1R3R w kq - 0 17"},
                {"m":"e4","from":"e3","to":"e4","fen":"r3kn1r\/1p1b1pp1\/p1p2b1p\/q2p4\/3PP3\/P1NB1P1P\/1PQ1N1P1\/1K1R3R b kq - 0 17"},
                {"m":"Ne6","from":"f8","to":"e6","fen":"r3k2r\/1p1b1pp1\/p1p1nb1p\/q2p4\/3PP3\/P1NB1P1P\/1PQ1N1P1\/1K1R3R w kq - 1 18"},
                {"m":"e5","from":"e4","to":"e5","fen":"r3k2r\/1p1b1pp1\/p1p1nb1p\/q2pP3\/3P4\/P1NB1P1P\/1PQ1N1P1\/1K1R3R b kq - 0 18"},
                {"m":"Be7","from":"f6","to":"e7","fen":"r3k2r\/1p1bbpp1\/p1p1n2p\/q2pP3\/3P4\/P1NB1P1P\/1PQ1N1P1\/1K1R3R w kq - 1 19"},
                {"m":"f4","from":"f3","to":"f4","fen":"r3k2r\/1p1bbpp1\/p1p1n2p\/q2pP3\/3P1P2\/P1NB3P\/1PQ1N1P1\/1K1R3R b kq - 0 19"},
                {"m":"Nc7","from":"e6","to":"c7","fen":"r3k2r\/1pnbbpp1\/p1p4p\/q2pP3\/3P1P2\/P1NB3P\/1PQ1N1P1\/1K1R3R w kq - 1 20"},
                {"m":"f5","from":"f4","to":"f5","fen":"r3k2r\/1pnbbpp1\/p1p4p\/q2pPP2\/3P4\/P1NB3P\/1PQ1N1P1\/1K1R3R b kq - 0 20"},
                {"m":"Nb5","from":"c7","to":"b5","fen":"r3k2r\/1p1bbpp1\/p1p4p\/qn1pPP2\/3P4\/P1NB3P\/1PQ1N1P1\/1K1R3R w kq - 1 21"},
                {"m":"Rhf1","from":"h1","to":"f1","fen":"r3k2r\/1p1bbpp1\/p1p4p\/qn1pPP2\/3P4\/P1NB3P\/1PQ1N1P1\/1K1R1R2 b kq - 2 21"},
                {"m":"Qb6","from":"a5","to":"b6","fen":"r3k2r\/1p1bbpp1\/pqp4p\/1n1pPP2\/3P4\/P1NB3P\/1PQ1N1P1\/1K1R1R2 w kq - 3 22"},
                {"m":"Bxb5","from":"d3","to":"b5","fen":"r3k2r\/1p1bbpp1\/pqp4p\/1B1pPP2\/3P4\/P1N4P\/1PQ1N1P1\/1K1R1R2 b kq - 0 22"},
                {"m":"axb5","from":"a6","to":"b5","fen":"r3k2r\/1p1bbpp1\/1qp4p\/1p1pPP2\/3P4\/P1N4P\/1PQ1N1P1\/1K1R1R2 w kq - 0 23"},
                {"m":"Nf4","from":"e2","to":"f4","fen":"r3k2r\/1p1bbpp1\/1qp4p\/1p1pPP2\/3P1N2\/P1N4P\/1PQ3P1\/1K1R1R2 b kq - 1 23"},
                {"m":"b4","from":"b5","to":"b4","fen":"r3k2r\/1p1bbpp1\/1qp4p\/3pPP2\/1p1P1N2\/P1N4P\/1PQ3P1\/1K1R1R2 w kq - 0 24"},
                {"m":"Ncxd5","from":"c3","to":"d5","fen":"r3k2r\/1p1bbpp1\/1qp4p\/3NPP2\/1p1P1N2\/P6P\/1PQ3P1\/1K1R1R2 b kq - 0 24"},
                {"m":"cxd5","from":"c6","to":"d5","fen":"r3k2r\/1p1bbpp1\/1q5p\/3pPP2\/1p1P1N2\/P6P\/1PQ3P1\/1K1R1R2 w kq - 0 25"},
                {"m":"Nxd5","from":"f4","to":"d5","fen":"r3k2r\/1p1bbpp1\/1q5p\/3NPP2\/1p1P4\/P6P\/1PQ3P1\/1K1R1R2 b kq - 0 25"},
                {"m":"Qa5","from":"b6","to":"a5","fen":"r3k2r\/1p1bbpp1\/7p\/q2NPP2\/1p1P4\/P6P\/1PQ3P1\/1K1R1R2 w kq - 1 26"},
                {"m":"Nc7+","from":"d5","to":"c7","fen":"r3k2r\/1pNbbpp1\/7p\/q3PP2\/1p1P4\/P6P\/1PQ3P1\/1K1R1R2 b kq - 2 26"},
                {"m":"Kd8","from":"e8","to":"d8","fen":"r2k3r\/1pNbbpp1\/7p\/q3PP2\/1p1P4\/P6P\/1PQ3P1\/1K1R1R2 w - - 3 27"},
                {"m":"Nxa8","from":"c7","to":"a8","fen":"N2k3r\/1p1bbpp1\/7p\/q3PP2\/1p1P4\/P6P\/1PQ3P1\/1K1R1R2 b - - 0 27"},
                {"m":"Qxa8","from":"a5","to":"a8","fen":"q2k3r\/1p1bbpp1\/7p\/4PP2\/1p1P4\/P6P\/1PQ3P1\/1K1R1R2 w - - 0 28"},
                {"m":"d5","from":"d4","to":"d5","fen":"q2k3r\/1p1bbpp1\/7p\/3PPP2\/1p6\/P6P\/1PQ3P1\/1K1R1R2 b - - 0 28"},
                {"m":"Qc8","from":"a8","to":"c8","fen":"2qk3r\/1p1bbpp1\/7p\/3PPP2\/1p6\/P6P\/1PQ3P1\/1K1R1R2 w - - 1 29"},
                {"m":"Qe4","from":"c2","to":"e4","fen":"2qk3r\/1p1bbpp1\/7p\/3PPP2\/1p2Q3\/P6P\/1P4P1\/1K1R1R2 b - - 2 29"},
                {"m":"Re8","from":"h8","to":"e8","fen":"2qkr3\/1p1bbpp1\/7p\/3PPP2\/1p2Q3\/P6P\/1P4P1\/1K1R1R2 w - - 3 30"},
                {"m":"Rc1","from":"d1","to":"c1","fen":"2qkr3\/1p1bbpp1\/7p\/3PPP2\/1p2Q3\/P6P\/1P4P1\/1KR2R2 b - - 4 30"},
                {"m":"Qb8","from":"c8","to":"b8","fen":"1q1kr3\/1p1bbpp1\/7p\/3PPP2\/1p2Q3\/P6P\/1P4P1\/1KR2R2 w - - 5 31"},
                {"m":"e6","from":"e5","to":"e6","fen":"1q1kr3\/1p1bbpp1\/4P2p\/3P1P2\/1p2Q3\/P6P\/1P4P1\/1KR2R2 b - - 0 31"},
                {"m":"Bb5","from":"d7","to":"b5","fen":"1q1kr3\/1p2bpp1\/4P2p\/1b1P1P2\/1p2Q3\/P6P\/1P4P1\/1KR2R2 w - - 1 32"},
                {"m":"Qd4","from":"e4","to":"d4","fen":"1q1kr3\/1p2bpp1\/4P2p\/1b1P1P2\/1p1Q4\/P6P\/1P4P1\/1KR2R2 b - - 2 32"},
                {"m":"b6","from":"b7","to":"b6","fen":"1q1kr3\/4bpp1\/1p2P2p\/1b1P1P2\/1p1Q4\/P6P\/1P4P1\/1KR2R2 w - - 0 33"},
                {"m":"d6","from":"d5","to":"d6","fen":"1q1kr3\/4bpp1\/1p1PP2p\/1b3P2\/1p1Q4\/P6P\/1P4P1\/1KR2R2 b - - 0 33"},
                {"m":"Bf6","from":"e7","to":"f6","fen":"1q1kr3\/5pp1\/1p1PPb1p\/1b3P2\/1p1Q4\/P6P\/1P4P1\/1KR2R2 w - - 1 34"},
                {"m":"e7+","from":"e6","to":"e7","fen":"1q1kr3\/4Ppp1\/1p1P1b1p\/1b3P2\/1p1Q4\/P6P\/1P4P1\/1KR2R2 b - - 0 34"},
                {"m":"Kd7","from":"d8","to":"d7","fen":"1q2r3\/3kPpp1\/1p1P1b1p\/1b3P2\/1p1Q4\/P6P\/1P4P1\/1KR2R2 w - - 1 35"},
                {"m":"Qd5","from":"d4","to":"d5","fen":"1q2r3\/3kPpp1\/1p1P1b1p\/1b1Q1P2\/1p6\/P6P\/1P4P1\/1KR2R2 b - - 2 35"},
                {"m":"Bxf1","from":"b5","to":"f1","fen":"1q2r3\/3kPpp1\/1p1P1b1p\/3Q1P2\/1p6\/P6P\/1P4P1\/1KR2b2 w - - 0 36"},
                {"m":"Qc6+","from":"d5","to":"c6","fen":"1q2r3\/3kPpp1\/1pQP1b1p\/5P2\/1p6\/P6P\/1P4P1\/1KR2b2 b - - 1 36"}
            ]
        }';


ini_set('display_errors', 'on');
error_reporting(E_ALL);
date_default_timezone_set("Europe/Berlin");
# header("Content-type: application/json");

LudoDB::setHost('localhost');
LudoDB::setUser('root');
LudoDB::setPassword('administrator');
LudoDB::setDb('PHPUnit');

// Construct database tables
$tables = array('Move','Game','Fen','Metadata','MetadataValue');
foreach($tables as $table){
    $inst = new $table;
    $inst->drop();
    $inst->createTable();
}

$profiling = new Profiling('smart-folder-tree');

$gameData = json_decode($gameJSON, true);
LudoDB::enableLogging();

for($i=0;$i<1;$i++){
    $game = new Game();
    $game->setDatabaseId(100);
    $game->setFen($gameData['fen']);
    $game->setMetadata($gameData['metadata']);
    $game->setMoves($gameData['moves']);
    $game->commit();

   # $game = new Game($game->getId());
    #$data = $game->getValues();
}
echo $profiling->end();

# echo $game;

