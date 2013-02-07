<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 07.02.13

 */
class EcoMovesDetailed extends LudoDBCollection
{
    protected $config = array(
        "sql" => "select * from chess_eco where previous_fen_id=? and fen_id=? order by id",
        "model" => "Eco"
    );

}
