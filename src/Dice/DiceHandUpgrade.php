<?php

declare(strict_types=1);

namespace Emeu17\Dice;

/**
 * Class DiceHand.
 */
class DiceHandUpgrade extends DiceHand
{
    /**
     * Add dice of class $dice to DiceHand
     *
     */
    public function addDice(DiceInterface $dice) {
            $this->noDices++;
            $this->dices[] = $dice;
            return $this->noDices;
    }


    /**
     * Constructor to initiate noDices to zero.
     */
    public function __construct()
    {
        $this->noDices = 0;
    }

    /**
     * Takes array of selected dices and rolls only those dices
     * that are not in the array (array shows dices to save and not roll)
     */
    public function rollChosenDices(array $chosenDices): void
    {
        for ($i = 0; $i < $this->noDices; $i++) {
            if (!in_array($i, $chosenDices)) {
                $this->dices[$i]->roll();
            }
        }
    }

    public function getGraphic()
    {
        $class = [];
        for ($i = 0; $i < $this->noDices; $i++) {
            $class[$i] = $this->dices[$i]->asString();
        }
        return $class;
    }


}
