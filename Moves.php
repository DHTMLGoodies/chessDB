<?php
/**
 * Moves collection
 * User: Alf Magne
 * Date: 09.01.13
 * Time: 12:33
 */
class Moves extends LudoDBCollection
{
    protected $JSONConfig = true;
    private $startingVariation = false;
    private $endingVariation = false;

    public function setMoves($moves)
    {
        $this->deleteRecords();
        $this->addLineOfMoves($moves);
    }

    private function addLineOfMoves($moves, $parentId = 0)
    {
        foreach ($moves as $move) {
            $this->addMove($move, $parentId);
            if (isset($move['variations'])) {
                foreach ($move['variations'] as $variation) {
                    $this->setStartVariationFlag();
                    $this->addLineOfMoves($variation);
                    $this->setEndVariationFlag();
                }
            }
        }
    }

    /**
     * @param $move
     * @param int $parentId
     * @return Move|null
     */
    private function addMove($move)
    {
        $m = $this->parser->getModel();
        $m->setValues($move);
        if (isset($move['fen'])) $m->setFen($move['fen']);
        $m->setGame($this->constructorValues[0]);
        $this->setStartVariationValue($m);
        $this->setEndVariationValue($m);
        $m->commit();
        return $m;
    }

    private function setStartVariationFlag()
    {
        $this->startingVariation = true;
    }

    private function setEndVariationFlag()
    {
        $this->endingVariation = true;
    }


    private function setStartVariationValue(Move $move)
    {
        if ($this->startingVariation) {
            $this->startingVariation = false;
            $move->startVariation();
        }
    }

    private function setEndVariationValue(Move $move)
    {
        if ($this->endingVariation) {
            $this->endingVariation = false;
            $move->endVariation();
        }
    }

    /**
     * @param LudoDBModel $model
     * @param array $columns
     * @return array
     */
    protected function getValuesFromModel($model, $columns)
    {
        return $model->getSomeValuesFiltered($columns);
    }


    private $values = array();
    private $currentBranch;
    private $lastMove;
    private $branches = array();

    public function getValues()
    {
        $this->values = array();
        $this->currentBranch = & $this->values;
        $model = $this->parser->getModel();
        $model->disableCommit();

        $columns = array('from_square', 'to_square', 'notation', 'comment');

        foreach ($this as $move) {
            if (!isset($columns)) $columns = array_keys($move);
            $model->clearValues();
            $model->setValues($move);

            $moveValues = $this->getValuesFromModel($model, $columns);
            if ($move['start_variation']) {
                $this->startBranch();
            }
            if ($move['end_variation']) {
                $this->endBranch();
            }
            $this->appendMoveToValues($moveValues);
        }
        $model->enableCommit();
        return $this->values;
    }

    private function appendMoveToValues($move)
    {
        $this->currentBranch[] = & $move;
        $this->lastMove = & $move;
    }

    private function startBranch()
    {
        if (!isset($this->lastMove['variations'])) {
            $this->lastMove['variations'] = array();
        }
        $variation = array();
        $this->lastMove['variations'][] = & $variation;
        $this->currentBranch = & $variation;
        $this->branches[] = & $variation;
    }

    private function endBranch()
    {
        array_pop($this->branches);
        $this->currentBranch = & $this->branches[count($this->branches) - 1];
        if (!isset($this->currentBranch)) $this->currentBranch = & $this->values;
    }
}
