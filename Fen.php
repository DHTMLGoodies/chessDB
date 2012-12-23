<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 23.12.12
 * Time: 20:08
 */
class Fen extends LudoDbTable
{
    protected $config = array(
        'table' => 'Fen',
        'columns' => array(
            'id' => 'int_auto_increment not null',
            'fen' => 'varchar(64) not null primary key'
        )
    );

    public function setFen($fen){
        $fen = explode(" ", $fen);
        $fen = $fen[0];
        $this->setValue('fen', $fen);
    }

}