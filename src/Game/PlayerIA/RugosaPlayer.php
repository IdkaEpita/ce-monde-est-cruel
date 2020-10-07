<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class RugosaPlayers
 * @package Hackathon\PlayerIA
 * @author Arthur Laurent
 */

/*
 * Premier tour : modulo sur la deuxième lettre du nom de l'adversaire pour le premier choice
 * 1. Check si un choix est trop utilisé par l'opponent pour choisir le move
 * 2. check si les 3 derniers choix de l'adversaire sont les mêmes, dans le cas échéant, le contrer
 * 3. check à partir des 3 derniers choix si l'adversaire fait un coup sur deux un choix particulier
 * 4. blocage de l'algo qui est censé contrer l'algo qui joue l'inverse de ce que l'opponent a joué la fois d'avant
 * 5. algo qui choisi l'inverse de ce que l'opponent a joué au round dernier.
 */
class RugosaPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {

        $opname = $this->result->getStatsFor($this->opponentSide)['name'][1];


        if ($this->result->getLastChoiceFor($this->opponentSide) === 0) {
            if (ord($opname)%3 === 0) {
                return parent::paperChoice();
            }
            elseif (ord($opname)%3 === 1) {
                return parent::scissorsChoice();
            }
            else {
                return parent::rockChoice();
            }
        }

        $stat = $this->result->getChoicesFor($this->opponentSide);
        $lastmove = 'paper';
        $blastmove = 'paper';
        $bblastmove = 'paper';
        $rround = 0;
        $paper = 0;
        $rock = 0;
        $scissors = 0;
        foreach ($stat as &$value) {

            if ($value == parent::rockChoice()){
                $rock += 1;
            }
            if ($value == parent::paperChoice()){
                $paper += 1;
            }
            if ($value == parent::scissorsChoice()){
                $scissors += 1;
            }
            $bblastmove = $blastmove;
            $blastmove = $lastmove;
            $lastmove = $value;
            $rround += 1;
        }
        if ($paper > $rock + $scissors) {
            return parent::scissorsChoice();
        }
        if ($scissors > $rock + $paper) {
            return parent::rockChoice();
        }
        if ($rock > $paper + $scissors) {
            return parent::paperChoice();
        }

        if ($lastmove === $blastmove and $blastmove === $bblastmove) {
            if ($lastmove === 'paper'){
                return parent::scissorsChoice();
            }
            if ($lastmove === 'scissors'){
                return parent::rockChoice();
            }
            if ($lastmove === 'rock'){
                return parent::paperChoice();
            }
        }

        if ($lastmove === $bblastmove) {
            if ($blastmove === 'paper'){
                return parent::scissorsChoice();
            }
            if ($blastmove === 'scissors'){
                return parent::rockChoice();
            }
            if ($blastmove === 'rock'){
                return parent::paperChoice();
            }
        }

        if (($this->result->getNbRound() > 1) and $this->result->getLastChoiceFor($this->opponentSide) === 'scissors' and $this->result->getLastChoiceFor($this->mySide) === 'paper') {
            return parent::paperChoice();
        }
        elseif (($this->result->getNbRound() > 1) and $this->result->getLastChoiceFor($this->opponentSide) === 'rock' and $this->result->getLastChoiceFor($this->mySide) === 'scissors') {
            return parent::scissorsChoice();
        }
        elseif (($this->result->getNbRound() > 1) and $this->result->getLastChoiceFor($this->opponentSide) === 'paper' and $this->result->getLastChoiceFor($this->mySide) === 'rock') {
            return parent::rockChoice();
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
