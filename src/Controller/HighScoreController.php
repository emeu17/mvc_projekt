<?php

namespace App\Controller;

use Emeu17\Dice\DiceHand;
use Emeu17\Entity\Score;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class HighScoreController extends AbstractController
{
    /**
    * Compare two values in array of objects.
    * Sort desc (playerScore)
    */
    public function cmp($value1, $value2)
    {
        return $value1->comp < $value2->comp;
    }

    /**
     * @Route("/diceGame/highScore", name="score")
    */
    public function diceHighScore(): Response
    {
        $scores = $this->getDoctrine()
            ->getRepository(Score::class)
            ->findAll();

        //add comparison between no of rounds won player vs computer
        foreach ($scores as $score) {
                $score->comp = ($score->getComputerScore() != 0) ? $score->getPlayerScore() / $score->getComputerScore() :  $score->getPlayerScore() / 1;
        }

        usort($scores, array($this, "cmp"));

        return $this->render('diceHighScore.html.twig', [
            'scores' => $scores,
        ]);
    }

    /**
     * @Route("/diceGame/diceStat", name="diceStat")
    */
    public function diceScoreStat(Request $request): Response
    {
        $scoreId = $request->query->get('id');

        $score = $this->getDoctrine()
            ->getRepository(Score::class)
            ->find($scoreId);

        $scoreStat = $score->getDiceStat();
        $diceStat = $this->sortStat($scoreStat);

        //create histogram
        $hist = $this->createHist($diceStat);

        //get player name
        $name = $score->getName();

        return $this->render('diceScoreStat.html.twig', [
            'id' => $scoreId,
            'score' => $scoreStat,
            'diceStat' => $diceStat,
            'hist' => $hist,
            'name' => $name,
        ]);
    }

    public function sortStat($stat): array
    {
        // $outputString = preg_replace('/[^0-9]/', '', $score->getDiceStat());

        //get all numbers from string with numbers like 1, 3, 4, 6...
        $matches = [];
        preg_match_all('!\d+!', $stat, $matches);
        //sort values low ot high
        sort($matches[0]);
        //count values at each value 1 through 6
        $myDices = array_count_values($matches[0]);
        return $myDices;
    }

    //create histogram
    public function createHist($myDices): array
    {
        $hist = [];
        for ($i = 1; $i <= 6; $i++) {
            $hist[$i] = $i . ": ";
            if (array_key_exists($i, $myDices)) {
                for ($j = 0; $j < $myDices[$i]; $j++) {
                    $hist[$i] .= "*";
                }
            }
        }
        return $hist;
    }
}
