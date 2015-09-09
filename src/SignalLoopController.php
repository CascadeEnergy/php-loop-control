<?php
// For signal handlers
declare(ticks = 1);

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
            $this->isHandlerInstalled = true;
        }

        return $this->isRunning;
    }

    public function handler($signal)
    {
        if ($signal === SIGTERM) {
            $this->isRunning = false;
        }
    }
}
