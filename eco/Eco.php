<?php
/**
 * Eco table
 * User: Alf Magne Kalleland
 * Date: 06.02.13
 */
class Eco extends LudoDBModel implements LudoDBService
{
    protected $JSONConfig = true;

    // TODO refactor collection

    public function getValidServices(){
        return array('moves','read');
    }

    private $fen;
    private $previousFen;

    public function __construct($previousFen = null, $fen = null){
        if(!isset($previousFen))$previousFen = ChessRegistry::getDefaultFen();
        $this->fen = $this->getValidFen($fen);
        $this->previousFen = $this->getValidFen($previousFen);
        parent::__construct();
    }

    private function getValidFen($fen){
        return isset($fen) ? str_replace("_", "/", $fen) : null;
    }

    public function validateArguments($service, $arguments){
        return count($arguments) === 1 || ($service == 'moves');
    }

    public function validateServiceData($service, $data){
        return true;
    }

    public function moves(){
        if(isset($this->fen) && $this->fen){
            $moves = new EcoMovesDetailed(Fen::getIdByFen($this->previousFen),Fen::getIdByFen($this->fen));
        }else{
            $moves = new EcoMoves(Fen::getIdByFen($this->previousFen));
        }
        return $moves->read();
    }

    /**
     * Recreate ECO databaes tables from JSONConfig/eco.data.json
     * @throws Exception
     */
    public function generate(){
        if(!file_exists($this->getPgnFile())){
            throw new Exception("Eco file ". $this->getPgnFile(). " does not exists");
        }
        if(!$this->exists())$this->createTable();
        $this->deleteTableData()->yesImSure();
        $this->moveDataIntoJSONFile($this->getJSONData());
        $this->insertDefaultData();
    }
    private function moveDataIntoJSONFile($data){
        file_put_contents($this->parser->getPathToJsonConfigDefaultData(), json_encode($data) );
    }

    private function getJSONData(){
        $data = array();
        $pgnParser = new PgnParser($this->getPgnFile());
        $pgnGames = $pgnParser->getUnparsedGames();

        for($i=0, $count = count($pgnGames);$i<$count;$i++){
            $parser = new PgnParser();
            $parser->setPgnContent($pgnGames[$i]);
            $parsedGame = $parser->getFirstGame();
            $line = $this->getEcoLine($parsedGame);
            if(isset($line))$data[] = $line;
        }
        return $data;
    }

    private function getEcoLine($eco){
        $ecoCode = $eco['site'];
        $openingName = $eco['white'];
        $variation = isset($eco['black']) ? $eco['black'] : '';

        $moves = $eco['moves'];
        if(count($moves) === 0){
            return null;
        }

        $index = count($moves)-1;
        $lastMove = $moves[$index];
        $fenId = Fen::getIdByFen($lastMove['fen']);
        if($index === 0){
            $previousFen = $eco['fen'];
        }else{
            $previousFen = $moves[$index-1]['fen'];
        }
        $previousFenId = isset($previousFen) ? Fen::getIdByFen($previousFen) : null;
        $fromSquare = $lastMove['from'];
        $toSquare = $lastMove['to'];
        $notation = $lastMove['m'];

        return array(
            'eco_code' => $ecoCode,
            'opening_name' => $openingName,
            'variation' => $variation,
            'fen_id' => $fenId,
            'previous_fen_id' => $previousFenId,
            'from_square' => $fromSquare,
            'to_square' => $toSquare,
            'notation' => $notation
        );
    }

    private function getPgnFile(){
        return $this->parser->getFileLocation()."/pgn/eco.pgn";
    }

    public function cacheEnabled(){
        return true;
    }
}
