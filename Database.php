<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne
 * Date: 18.01.13
 */
class Database extends LudoDBModel implements LudoDBService
{
    protected $JSONConfig = true;

    public function areValidServiceArguments($service, $arguments){
        return count($arguments) === 1 && is_numeric($arguments[0]);
    }

    public static function getValidServices(){
        return array('games','read','save');
    }

    public function games(){
        $g = new Games($this->getId());
        return $g->read();
    }

    public function setTitle($title){
        $this->setValue('title', $title);
    }

    public function getTitle(){
        return $this->getValue('title');
    }
}
