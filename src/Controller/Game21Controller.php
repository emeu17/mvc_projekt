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

class Game21Controller extends AbstractController
{

    /**
     * @Route("/startGame", name="startGame")
    */
    public function startgame(SessionInterface $session): Response
    {
        //if session variables are not set, give them value of 0
        $session->set('noRounds', $session->get('noRounds') ?? 0);
        $session->set('compScore', $session->get('compScore') ?? 0);
        $session->set('playScore', $session->get('playScore') ?? 0);
        $session->set('points', $session->get('points') ?? 100);

        return $this->render('game21.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/startGame/reset", name="resetGame")
    */
    public function resetGame(SessionInterface $session): RedirectResponse
    {
        // $session = new Session();
        // $session->start();
        $session->clear();
        // $session->set('tesst', 'test123');

        return $this->redirectToRoute('startGame');

    }

    /**
     * @Route("/startGame/process", name="processGame")
    */
    public function processGame(Request $request, SessionInterface $session): RedirectResponse
    {
        $dices = (int) $request->request->get('dices') ?? 2;
        $bet = (int) $request->request->get('bet') ?? 0;
        $session->set('bet', $bet);
        $session->set('diceHand', new DiceHand($dices));

        return $this->redirectToRoute('diceGame');
    }

    /**
     * @Route("/diceGame", name="diceGame")
    */
    public function diceGame(SessionInterface $session): Response
    {
        $callable = $session->get('diceHand');
        $throw = $callable->getLastRoll();
        $sum = $callable->getSum();

        return $this->render('diceGame.html.twig', [
            'throw' => $throw,
            'sum' => $sum,
        ]);
    }

    /**
     * @Route("/diceGame/process2", name="processThrow")
    */
    public function processThrow(SessionInterface $session, Request $request): RedirectResponse
    {
        $stop = $request->request->get('stop') ?? null;

        if ($stop) {
            return $this->redirectToRoute('diceResult');
        }
        $callable = $session->get('diceHand');
        $callable->roll();
        $sum = $callable->getSum();
        //save dices
        if ($sum != 0) {
            $throw = $callable->getLastRoll();
            $session->set('dices', $session->get('dices') . $throw . ", ");
        }

        $session->set('diceHand', $callable);
        if ($sum >= 21) {
            return $this->redirectToRoute('diceResult');
        }

        return $this->redirectToRoute('diceGame');
    }

    /**
     * @Route("/diceGame/result", name="diceResult")
    */
    public function diceResult(SessionInterface $session): Response
    {
        $callable = $session->get('diceHand');
        $throw = $callable->getLastRoll();
        $sum = $callable->getSum();

        //get winner and set points from betting
        $result = $this->getWinner($callable, $session);
        $session->set('noRounds', 1 + $session->get('noRounds'));
        $session->remove('diceHand');
        $dice_no = $session->get('dices');


        return $this->render('diceResult.html.twig', [
            'throw' => $throw,
            'sum' => $sum,
            'result' => $result,
            'dice_no' => $dice_no,
        ]);
    }

    /**
     * Returns the winner in a DiceHand object
     *
     */
    public function getWinner($callable, $session): string
    {
        $sum = $callable->getSum();
        $bet = $session->get('bet');
        if ($callable->getSum() == 21) {
            $res = "CONGRATULATIONS! You got 21!";
            // $winner = "player";
            $session->set('playScore', 1 + $session->get('playScore'));
            $session->set('points', $session->get('points') + $bet*1.5);
            return $res;
        }
        if ($callable->getSum() > 21) {
            $res = "You passed 21 and lost, sum: " . $sum;
            // $winner = "computer";
            $session->set('compScore', 1 + $session->get('compScore'));
            $session->set('points', $session->get('points') - $bet);
            return $res;
        }
        // if sum less than 21, simulate computer throws
        $computerScore = $callable->simulateComputer((int) $sum);
        if($computerScore <= 21) {
            $res = "Computer wins, got sum = " . $computerScore . ", your sum = " . $sum;
            // $winner = "computer";
            $session->set('compScore', 1 + $session->get('compScore'));
            $session->set('points', $session->get('points') - $bet);
            return $res;
        }
        $res = "You win, computer got sum = " . $computerScore . ", your sum = " . $sum;
        // $winner = "player";
        $session->set('playScore', 1 + $session->get('playScore'));
        $session->set('points', $session->get('points') + $bet);
        return $res;
    }

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

    /**
     * @Route("/diceGame/diceSaveScore", name="diceSaveScore")
    */
    public function diceSaveScore(): Response
    {
        return $this->render('diceSaveScore.html.twig');
    }


    /**
     * @Route("/diceGame/saveScore", name="saveScore")
    */
    public function saveScore(SessionInterface $session, Request $request): RedirectResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $newScoreName = $request->request->get('playerName') ?? "unknown";
        $newScorePlayer = $session->get('playScore');
        $newScoreComputer = $session->get('compScore');
        $newPoints = $session->get('points');
        $newStat = $session->get('dices');

        $highscore = new Score();
        $highscore->setName($newScoreName);
        $highscore->setPlayerScore($newScorePlayer);
        $highscore->setComputerScore($newScoreComputer);
        $highscore->setPoints($newPoints);
        $highscore->setDiceStat($newStat);

        $entityManager->persist($highscore);
        $entityManager->flush();

        $session->clear();
        return $this->redirectToRoute('score');
    }
}
