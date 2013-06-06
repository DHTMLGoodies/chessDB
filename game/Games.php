<?php
/**
 *
 * Returns games in a database
 * To view on web, create a grid or list and set datasource to
 * {
 *  type:"dataSource.Collection",
 *  "resource": "Games",
 *  "service": "read"
 *  "arguments": "<Title or id of database>"
 * }
 * User: Alf Magne
 * Date: 05.02.13
 */
class Games extends LudoDBCollection implements LudoDBService
{
    protected $JSONConfig = true;

    public function getValidServices(){
        return array("read");
    }

    public function getSql(){
        return is_numeric($this->arguments[0]) ?
            "select id,white,black,result,event,site,eco,game_date,round from chess_game where database_id=?":
            "select g.id,g.white,g.black,g.result,g.event,g.site,g.eco,g.game_date,g.round from chess_game g, chess_database d where g.database_id = d.id and d.title=?";
    }

    public function getOnSuccessMessageFor($service){
        return "";
    }

    public function validateArguments($service, $arguments){
        return count($arguments) === 1;
    }

    public function validateServiceData($service, $data){
        return true;
    }

    public function shouldCache($service){
        return $service === "read";
    }
}
