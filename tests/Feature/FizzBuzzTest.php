<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FizzBuzzTest extends TestCase
{
    /**
     * Valid Input
     *
     */
    public function testValidInput()
    {
        $this->assertContains('Fizz',fizzBuzz());
    }

    /**
     * start < 0
     *
     */
    public function testStartLessThanZero()
    {
         $this->assertContains('Fizz',fizzBuzz(0));

    }

    /**
     * stop > 100
     *
     */
    public function testStopGreaterThanHundred()
    {
         $this->assertContains('Fizz',fizzBuzz(1,120));

    }

    /**
     * start = stop
     *
     */
    public function testStartEqualsStop()
    {
         $this->assertContains('Fizz',fizzBuzz(23,23));

    }

    /**
     * non-numeric input
     *
     */
    public function testNonNumericInput()
    {
         $this->assertContains('Fizz',fizzBuzz('ping','pong'));
    }
}
