<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 25.01.13
 * Time: 23:33
 */
class ChatMessage extends LudoDBModel
{
    protected $JSONConfig = true;

    public function setChat(Chat $chat){
        $this->setValue('chat', $chat->getId());
    }

    public function setMessage($message){
        $this->setValue('message', $message);
    }

    public function setByUser($userId){
        $this->setValue('by_user', $userId);
    }
}
