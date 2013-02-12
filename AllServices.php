<?php
/**
 * Comment pending.
 * User: Alf Magne Kalleland
 * Date: 12.02.13
 * Time: 21:49
 */
class AllServices implements LudoDBService
{
    public function __construct(){
        LudoDB::registerService('Game');
        LudoDB::registerService('Fen');
        LudoDB::registerService('Databases');
        LudoDB::registerService('Database');
        LudoDB::registerService('Folders');
        LudoDB::registerService('Folder');
        LudoDB::registerService('Eco');
        LudoDB::registerService('Seek');
        LudoDB::registerService('Session');
        LudoDB::registerService('Folder');
        LudoDB::registerService('ChessLogin');
        LudoDB::registerService('ChessDBInstaller');
        LudoDB::registerService('Chat');
        LudoDB::registerService('ChatMessages');
        LudoDB::registerService('Player');
        LudoDB::registerService('Countries');
        LudoDB::registerService('GameImport');
    }

    public function read(){
        return LudoDB::getAllServices();
    }
    public function cacheEnabled(){
        return false;
    }

    public function validateArguments($service, $arguments){
        return count($arguments) === 0;
    }

    public function validateServiceData($service, $data){
        return true;
    }

    public function getValidServices(){
        return array('read');
    }
}
