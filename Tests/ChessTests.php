<?php

class ChessTests extends PHPUnit_Framework_TestCase
{
    private $connected = false;
    public function setUp(){
        if(!$this->connected){
            $conn = mysql_connect('localhost','root','administrator');
            mysql_select_db('PHPUnit',$conn);;
        }
    }
}
