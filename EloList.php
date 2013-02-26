<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 26.02.13
 * Time: 22:25
 */
class EloList extends LudoDBCollection
{
    protected $config = array(
        "sql" => "select elo from chess_elo where player_id=? and category=? order by id desc limit 20"
    );
}
