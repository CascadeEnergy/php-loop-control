<?php

namespace CascadeEnergy\Tests\LoopControl;

use CascadeEnergy\LoopControl\InterruptableLoopController;

class InterruptableLoopControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var InterruptableLoopController */
    private $loopController;

    public function setUp()
    {
        $this->loopController = new InterruptableLoopController();
    }

    public function testItShouldContinueTheLoopIndefinitelyByDefault()
    {
        $this->assertTrue($this->loopController->shouldContinue());
        $this->assertTrue($this->loopController->shouldContinue());
    }

    public function testItShouldStopTheLoopWhenInterrupted()
    {
        $this->assertTrue($this->loopController->shouldContinue());
        $this->loopController->interrupt();
        $this->assertFalse($this->loopController->shouldContinue());
    }
}
