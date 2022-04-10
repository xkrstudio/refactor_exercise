<?php

use PHPUnit\Framework\TestCase;

class FulfillableOrderTest extends TestCase {

    public function setUp() : void {
        $this->fulfillableOrder = new FulfillableOrder();
    }

    protected function tearDown(): void {
        parent::tearDown();
        unset($this->fulfillableOrder);
    }

    public function testCheckParameter() : void {
        $this->expectOutputString('Ambiguous number of parameters!', $this->fulfillableOrder->checkParameter(0));
    }
    
}
?>