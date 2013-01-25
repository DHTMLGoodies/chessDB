<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne
 * Date: 25.01.13
 * Time: 16:36
 * To change this template use File | Settings | File Templates.
 */
class Chat extends LudoDBTable
{
    protected $JSONConfig = true;

    public function setChannel($channel){
        $this->setValue('channel', $channel);
    }
    public function addMessage($message, $by){
        if(!$this->getId())$this->commit();
        $m = new ChatMessage();
        $m->setChat($this);
        $m->setMessage($message);
        $m->setByUser($by);
        $m->commit();
    }
}
