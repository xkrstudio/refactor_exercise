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
    
}
?>
