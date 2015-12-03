<?php

namespace CascadeEnergy\Tests\LoopControl;

use CascadeEnergy\LoopControl\SignalLoopController;

class SignalLoopControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var SignalLoopController */
    private $loopController;

    public function setUp()
    {
        $this->loopController = new SignalLoopController();

        if (!$this->isTestPossible()) {
            return;
        }
    }

    public function testItShouldContinueTheLoopIndefinitelyByDefault()
    {
        $this->assertTrue($this->loopController->shouldContinue());
        $this->assertTrue($this->loopController->shouldContinue());
    }

    public function testItShouldInstallASignalHandlerWhenShouldContinueIsFirstCalled()
    {
        $this->assertAttributeEquals(false, 'isHandlerInstalled', $this->loopController);
        $this->loopController->shouldContinue();
        $this->assertAttributeEquals(true, 'isHandlerInstalled', $this->loopController);
    }

    public function testItShouldStopWhenASigIntIsReceived()
    {
        $this->assertTrue($this->loopController->shouldContinue());
        posix_kill(posix_getpid(), SIGINT);
        $this->assertFalse($this->loopController->shouldContinue());
    }

    public function testItShouldStopWhenASigKillIsReceived()
    {
        $this->assertTrue($this->loopController->shouldContinue());
        posix_kill(posix_getpid(), SIGTERM);
        $this->assertFalse($this->loopController->shouldContinue());
    }

    private function isTestPossible()
    {
        if (!function_exists('pcntl_signal')) {
            $this->markTestSkipped('The pcntl_signal function is not available.');
            return false;
        }

        if (!function_exists('posix_kill')) {
            $this->markTestSkipped('The posix_kill function is not available.');
            return false;
        }

        return true;
    }
}
