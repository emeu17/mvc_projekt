<?php

declare(strict_types=1);

namespace Emeu17\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceHandUpgradeTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHand = new DiceHandUpgrade();
        $this->assertInstanceOf("\Emeu17\Dice\DiceHandUpgrade", $diceHand);

        $res = $diceHand->addDice(new Dice());
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     * roll a chosen dice and check that a value is set correctly
     */
    public function testRollChosenDice()
    {
        $diceHand = new DiceHandUpgrade();
        $this->assertInstanceOf("\Emeu17\Dice\DiceHandUpgrade", $diceHand);

        $diceHand->addDice(new Dice());
        $diceHand->addDice(new Dice());

        //only rolls dices not in array
        //ie array is dices to save from rolling
        $diceHand->rollChosenDices([1]);
        $res = $diceHand->getDiceValue(0);

        $this->assertTrue(1 <= $res);
        $this->assertTrue($res <= 6);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     * Roll dices and get array of ints for creating css dice-classes
     */
    public function testGetGraphic()
    {
        $diceHand = new DiceHandUpgrade();
        $this->assertInstanceOf("\Emeu17\Dice\DiceHandUpgrade", $diceHand);

        $diceHand->addDice(new Dice());
        $diceHand->addDice(new Dice());

        $diceHand->roll();

        $res = $diceHand->getGraphic();
        $numDices = count($res);

        for ($i = 0; $i < $numDices; $i++) {
            $this->assertTrue(1 <= (int) $res[$i]);
            $this->assertTrue((int) $res[$i] <= 6);
        }
    }
}
