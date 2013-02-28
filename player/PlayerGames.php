<?php
/**
 * Games for a player
 * User: Alf Magne Kalleland
 * Date: 13.02.13
 * Time: 01:41
 */
class PlayerGames extends LudoDBCollection
{
    public function __construct($playerId, $finished, $category = 1){
        parent::__construct($playerId, $playerId, $finished, $category);
    }
    protected $config = array(
        "sql"=> "select * from chess_game where white_id=? or black_id=? and finished=? and category = ? order by id desc limit 100"
    );
}
