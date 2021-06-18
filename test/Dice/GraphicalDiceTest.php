<?php

declare(strict_types=1);

namespace Emeu17\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GraphicalDiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new GraphicalDice();
        $this->assertInstanceOf("\Emeu17\Dice\GraphicalDice", $dice);

        $res = $dice->getFaces();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties, get last roll as string
     */
    public function testRollGetAsString()
    {
        $dice = new GraphicalDice();
        $this->assertInstanceOf("\Emeu17\Dice\GraphicalDice", $dice);

        $res1 = $dice->roll();
        $res = $dice->asString();
        $exp = "dice-" . strval($res1);
        $this->assertEquals($exp, $res);
    }
}
