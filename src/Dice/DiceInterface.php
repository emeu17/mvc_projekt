<?php

declare(strict_types=1);

namespace Emeu17\Dice;

/**
 * Interface DiceInterface.
 */
interface DiceInterface
{
    public function roll(): int;
    public function getLastRoll(): int;
    public function asString(): string;
}
