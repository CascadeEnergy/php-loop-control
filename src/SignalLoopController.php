<?php

namespace CascadeEnergy\LoopControl;

class SignalLoopController implements LoopControllerInterface
{
    private $isRunning = true;
    private $isHandlerInstalled = false;

    /**
     * @return bool True if the loop should continue, false otherwise
     */
    public function shouldContinue()
    {
        if (!$this->isHandlerInstalled) {
            pcntl_signal(SIGTERM, [$this, 'handler']);
            pcntl_signal(SIGINT, [$this, 'handler']);
            $this->isHandlerInstalled = true;
        }

        pcntl_signal_dispatch();

        return $this->isRunning;
    }

    public function handler($signal)
    {
        if ($signal === SIGTERM || $signal === SIGINT) {
            $this->isRunning = false;
        }
    }
}
