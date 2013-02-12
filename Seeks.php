<?php
/**
 * Seeks for a player
 * User: Alf Magne Kalleland
 * Date: 12.02.13
 * Time: 23:31
 */
class Seeks extends LudoDBCollection
{
    protected $config = array(
        "sql" => "select * from chess_seek where player_id=? order by id desc",
        "model"=> "Seek"
    );
}
