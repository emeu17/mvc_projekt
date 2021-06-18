<?php

declare(strict_types=1);

namespace Emeu17\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Emeu17\Dice\DiceHand", $diceHand);

        $res = $diceHand->getSum();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that setting
     * a sum yields the correct result
     */
    public function testSetSum()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Emeu17\Dice\DiceHand", $diceHand);

        $diceHand->setSum(2);
        $res = $diceHand->getSum();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that after
     * rolling dices the correct array of dice rolls
     * can be retrieved
     */
    public function testGetLastRollArray()
    {
        $diceHand = new DiceHand(2);
        $this->assertInstanceOf("\Emeu17\Dice\DiceHand", $diceHand);

        $diceHand->roll();
        $res = $diceHand->getLastRollArray();
        $exp = [$diceHand->getDiceValue(0), $diceHand->getDiceValue(1)];
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that after
     * rolling dices the correct string of dice rolls
     * can be retrieved
     */
    public function testGetLastRollString()
    {
        $diceHand = new DiceHand(2);
        $this->assertInstanceOf("\Emeu17\Dice\DiceHand", $diceHand);

        $diceHand->roll();
        $res = $diceHand->getLastRoll();
        $exp = $diceHand->getDiceValue(0) . ", " . $diceHand->getDiceValue(1);
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that computer
     * simulation retrieves the correct result
     * should roll dice(s) until >= number sent in
     */
    public function testSimulateComputer()
    {
        $diceHand = new DiceHand(2);
        $this->assertInstanceOf("\Emeu17\Dice\DiceHand", $diceHand);

        $diceHand->roll();
        $res = $diceHand->simulateComputer(15);
        $this->assertTrue($res >= 15);
    }
}
