<?php

namespace CascadeEnergy\LoopControl;

class InterruptableLoopController implements LoopControllerInterface
{
    private $isRunning = true;
    private $isHandlerInstalled = false;

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
        if (!$this->isHandlerInstalled) {
            pcntl_signal(SIGTERM, [$this, 'handler']);
        }

        return $this->isRunning;
    }

    private function handler($signal)
    {
        if ($signal === SIGTERM) {
            $this->isRunning = false;
        }
    }
}
