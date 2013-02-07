<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 06.02.13
 */
class PlayerByName extends Player
{
    protected $JSONConfig = false;
    protected $config = array(
        "sql" => "select * from chess_player where full_name=?"
    );

    public function __construct($fullName = null){
        parent::__construct($fullName);
    }
}
