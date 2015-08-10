<?php

namespace CascadeEnergy\LoopControl;

interface LoopControllerInterface
{
    /**
     * @return bool True if the loop should continue, false otherwise
     */
    public function shouldContinue();
}
