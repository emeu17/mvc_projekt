<?php

declare(strict_types=1);

namespace Emeu17\Dice;

// use function Mos\Functions\{
//     destroySession,
//     redirectTo,
//     renderView,
//     renderTwigView,
//     sendResponse,
//     url
// };

/**
 * Class Dice.
 */
class Dice implements DiceInterface
{
    private $faces;
    private $roll = 0;

    public function __construct(int $faces=6)
    {
        $this->faces = $faces;
    }

    /**
     * Roll the dice and get the value of the last rolled dice.
     *
     * @return int as value of last rolled dice.
     */
    public function roll(): int
    {
        $this->roll = rand(1, $this->faces);

        return $this->roll;
    }

    /**
     * Get the value of the last rolled dice.
     *
     * @return int as value of last rolled dice.
     */

    public function getLastRoll(): int
    {
        return $this->roll;
    }

    /**
     * Get the value of the number of dice faces.
     *
     * @return int as value of no of dice faces.
     */

    public function getFaces(): int
    {
        return $this->faces;
    }

    public function asString(): string
    {
        return (string) $this->getLastRoll();
    }
}
