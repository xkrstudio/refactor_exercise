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

    public function testValidJSON() : void {
        $this->assertEquals('', $this->fulfillableOrder->validateJSON('{"1":8,"2":4,"3":5}'));
    }

    public function testInvalidJSON() : void {
        $this->expectOutputString('Invalid json!', $this->fulfillableOrder->validateJSON('invalid data'));
    }

    public function testReadOrderList() : void {
        $this->assertFileExists('orders.csv');

        $this->fulfillableOrder->readOrderList();
        $this->fulfillableOrder->sortOrderList();

        $reflector = new ReflectionClass(FulfillableOrder::class);

        $property = $reflector->getProperty('orderList');
        $property->setAccessible(true);

        $orderList = $property->getValue($this->fulfillableOrder);

        foreach ($orderList as $values) {
            $this->assertArrayHasKey('product_id', $values);
            $this->assertArrayHasKey('quantity', $values);
            $this->assertArrayHasKey('priority', $values);
            $this->assertArrayHasKey('created_at', $values);
        }
    }

    public function testPrintHeader() : void {
        $this->fulfillableOrder->readOrderList();
        $this->expectOutputString("product_id          quantity            priority            created_at          \n", $this->fulfillableOrder->printTableHeader());
    }

    public function testPrintSeparator() : void {
        $this->fulfillableOrder->readOrderList();
        $this->expectOutputString("================================================================================\n", $this->fulfillableOrder->printSeparator());
    }

    public function testPriorityText() : void {
        $reflectionMethod = new ReflectionMethod('FulfillableOrder', 'getPriorityText');
        $reflectionMethod->setAccessible(true);
        $this->assertEquals('low', $reflectionMethod->invokeArgs(new FulfillableOrder(), array('1')));
        $this->assertEquals('medium', $reflectionMethod->invokeArgs(new FulfillableOrder(), array('2')));
        $this->assertEquals('high', $reflectionMethod->invokeArgs(new FulfillableOrder(), array('3')));
    }
    
}
?>
