<?php

declare(strict_types=1);

namespace Emeu17\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Emeu17\Dice\Dice", $dice);

        $res = $dice->getFaces();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties, use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $dice = new Dice(2);
        $this->assertInstanceOf("\Emeu17\Dice\Dice", $dice);

        $res = $dice->getFaces();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that making a roll
     * results in the correct return int or string
     */
    public function testRollDice()
    {
        $dice = new Dice(1);
        $this->assertInstanceOf("\Emeu17\Dice\Dice", $dice);

        $res = $dice->roll();
        $exp = 1;
        $this->assertEquals($exp, $res);

        $res = $dice->getLastRoll();
        $exp = 1;
        $this->assertEquals($exp, $res);

        $res = $dice->asString();
        $exp = "1";
        $this->assertEquals($exp, $res);

    }

    /**
     * Construct object and verify that making a roll
     * results in the correct return int
     */
    public function testRollDiceMultipleFaces()
    {
        $dice = new Dice(6);
        $this->assertInstanceOf("\Emeu17\Dice\Dice", $dice);

        $res = $dice->roll();
        $expLow = 1;
        $expHigh = 6;
        $this->assertTrue($expLow <= $res);
        $this->assertTrue($expHigh >= $res);
    }
}
