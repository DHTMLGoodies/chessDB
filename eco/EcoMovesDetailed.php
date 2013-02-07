<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xait0020
 * Date: 07.02.13
 * Time: 00:37
 */
class EcoMovesDetailed extends LudoDBCollection
{
    protected $config = array(
        "sql" => "select * from chess_eco where previous_fen_id=? and fen_id=? order by id",
        "model" => "Eco"
    );

}
