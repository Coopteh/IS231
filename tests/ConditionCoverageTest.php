<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;


class ConditionCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }
    
    public function testCondition_AmountLessOrEqualZero_True(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->calculate(25, false, -10.0); // TRUE: выброс исключения
    }

    public function testCondition_AmountLessOrEqualZero_False(): void
    {
        $result = $this->service->calculate(25, false, 100.0); // FALSE: продолжение
        $this->assertIsFloat($result);
    }
    
    public function testCondition_AmountOver1000_True(): void
    {
        $result = $this->service->calculate(25, true, 1500.0);
        $this->assertEquals(0.20, $result);
    }

    public function testCondition_AmountOver1000_False(): void
    {
        $result = $this->service->calculate(25, false, 750.0);
        $this->assertContains($result, [0.0, 0.10]);
    }
    
    public function testCondition_IsVip_FirstCondition_True(): void
    {
        $result = $this->service->calculate(25, true, 1500.0);
        $this->assertEquals(0.20, $result);
    }

    public function testCondition_IsVip_FirstCondition_False(): void
    {
        $result = $this->service->calculate(25, false, 1500.0);
        $this->assertEquals(0.0, $result); // нет скидки, т.к. age<=60 и !isVip
    }
    
    public function testCondition_AmountOver500_True(): void
    {
        $result = $this->service->calculate(25, false, 750.0);
        $this->assertGreaterThanOrEqual(0.0, $result);
    }

    public function testCondition_AmountOver500_False(): void
    {
        $result = $this->service->calculate(25, false, 300.0);
        $this->assertEquals(0.0, $result);
    }
    
    public function testCondition_AgeOver60_True(): void
    {
        $result = $this->service->calculate(65, false, 750.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCondition_AgeOver60_False(): void
    {
        $result = $this->service->calculate(25, true, 750.0);
        $this->assertEquals(0.10, $result);
    }
    
    public function testCondition_IsVip_NestedCondition_True(): void
    {
        $result = $this->service->calculate(25, true, 750.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCondition_IsVip_NestedCondition_False(): void
    {
        $result = $this->service->calculate(25, false, 750.0);
        $this->assertEquals(0.0, $result);
    }
}