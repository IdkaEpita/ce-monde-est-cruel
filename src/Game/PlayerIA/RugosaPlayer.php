<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class RugosaPlayers
 * @package Hackathon\PlayerIA
 * @author Arthur Laurent
 */
class RugosaPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {
        if ($this->result->getLastChoiceFor($this->opponentSide) === 0) {
            return parent::paperChoice();
        }
        elseif ($this->result->getLastChoiceFor($this->opponentSide) === 'scissors') {
            return parent::rockChoice();
        }
        elseif ($this->result->getLastChoiceFor($this->opponentSide) === 'rock') {
            return parent::paperChoice();
        }
        elseif ($this->result->getLastChoiceFor($this->opponentSide) === 'paper') {
            return parent::scissorsChoice();
        }
        return parent::paperChoice();
    }
};
