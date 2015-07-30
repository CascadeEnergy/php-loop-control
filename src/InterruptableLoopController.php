<?php

namespace CascadeEnergy\LoopControl;

class InterruptableLoopController implements LoopControllerInterface
{
    private $isRunning = true;

    /**
     * Interrupts the loop at the next call to `shouldContinue`. Once interrupted the loop controller remains in
     * an interrupted state indefinitely.
     */
    public function interrupt()
    {
        $this->isRunning = false;
    }

    /**
     * @return bool True if the loop should continue, false otherwise
     */
    public function shouldContinue()
    {
        return $this->isRunning;
    }
}
