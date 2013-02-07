<?php
/**
 * Chess Chat
 * User: Alf Magne
 * Date: 25.01.13

 */
class Chat extends LudoDBModel
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
