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
        LudoDBServiceRegistry::register('Game');
        LudoDBServiceRegistry::register('Fen');
        LudoDBServiceRegistry::register('Databases');
        LudoDBServiceRegistry::register('Database');
        LudoDBServiceRegistry::register('Folders');
        LudoDBServiceRegistry::register('Folder');
        LudoDBServiceRegistry::register('Eco');
        LudoDBServiceRegistry::register('Seek');
        LudoDBServiceRegistry::register('Session');
        LudoDBServiceRegistry::register('Folder');
        LudoDBServiceRegistry::register('ChessLogin');
        LudoDBServiceRegistry::register('ChessDBInstaller');
        LudoDBServiceRegistry::register('Chat');
        LudoDBServiceRegistry::register('ChatMessages');
        LudoDBServiceRegistry::register('CurrentPlayer');
        LudoDBServiceRegistry::register('Player');
        LudoDBServiceRegistry::register('Countries');
        LudoDBServiceRegistry::register('GameImport');
        LudoDBServiceRegistry::register('ChessFS');
        LudoDBServiceRegistry::register('ChessFSPgn');
    }

    public function read(){
        return LudoDBServiceRegistry::getAll();
    }
    public function cacheEnabledFor($service){
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

    public function getOnSuccessMessageFor($service){
        return "";
    }
}
