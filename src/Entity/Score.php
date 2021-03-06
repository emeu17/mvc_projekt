<?php

namespace Emeu17\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Emeu17\Repository\ScoreRepository")
 */
 class Score
   {
       /**
        * @ORM\Id
        * @ORM\GeneratedValue
        * @ORM\Column(type="integer")
        */
       private $idScore;

       /**
        * @ORM\Column(type="string", length=50)
        */
       protected $name;

       /**
        * @ORM\Column(type="integer")
        */
       protected $playerScore;

       /**
        * @ORM\Column(type="integer")
        */
       protected $computerScore;

       /**
        * @ORM\Column(type="integer")
        */
       protected $points;

       /**
        * @ORM\Column(type="string", length=400)
        */
       protected $diceStat;

       /**
        * @ORM\Column(type="decimal")
        */
       protected $comp;


       public function getId()
       {
           return $this->idScore;
       }

       public function getName()
       {
           return $this->name;
       }

       public function setName($name)
       {
           $this->name = $name;
       }

       public function getPlayerScore()
       {
           return $this->playerScore;
       }

       public function setPlayerScore($playerScore)
       {
           $this->playerScore = $playerScore;
       }

       public function getComputerScore()
       {
           return $this->computerScore;
       }

       public function setComputerScore($computerScore)
       {
           $this->computerScore = $computerScore;
       }

       public function getPoints()
       {
           return $this->points;
       }

       public function setPoints($points)
       {
           $this->points = $points;
       }

       public function getDiceStat()
       {
           return $this->diceStat;
       }

       public function setDiceStat($diceStat)
       {
           $this->diceStat = $diceStat;
       }

       public function getComp()
       {
           return $this->comp;
       }

       public function setComp($comp)
       {
           $this->comp = $comp;
       }
   }
