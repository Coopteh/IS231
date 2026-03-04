<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для достижения покрытия условий (Condition Coverage)
 * Каждое булево подвыражение проверяется на true и false
 */
class ConditionCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    // =================================================================
    // УСЛОВИЕ 1: $amount <= 0
    // =================================================================
    
    public function testCondition_AmountLessOrEqualZero_True(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->calculate(30, false, -10.0);
    }

    public function testCondition_AmountLessOrEqualZero_False(): void
    {
        $result = $this->service->calculate(30, false, 100.0);
        $this->assertIsFloat($result);
    }

    // =================================================================
    // УСЛОВИЕ 2: $amount > 1000
    // =================================================================
    
    public function testCondition_AmountOver1000_True(): void
    {
        $result = $this->service->calculate(30, true, 1500.0);
        $this->assertEquals(0.20, $result);
    }

    public function testCondition_AmountOver1000_False(): void
    {
        $result = $this->service->calculate(30, true, 800.0);
        $this->assertEquals(0.10, $result);
    }

    // =================================================================
    // УСЛОВИЕ 3: $isVip (в составном && первого if)
    // =================================================================
    
    public function testCondition_IsVip_True_InFirstCondition(): void
    {
        $result = $this->service->calculate(30, true, 1200.0);
        $this->assertEquals(0.20, $result);
    }

    public function testCondition_IsVip_False_InFirstCondition(): void
    {
        $result = $this->service->calculate(30, false, 1200.0);
        $this->assertEquals(0.0, $result);
    }

    // =================================================================
    // УСЛОВИЕ 4: $amount > 500
    // =================================================================
    
    public function testCondition_AmountOver500_True(): void
    {
        $result = $this->service->calculate(65, false, 600.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCondition_AmountOver500_False(): void
    {
        $result = $this->service->calculate(65, false, 400.0);
        $this->assertEquals(0.0, $result);
    }

    // =================================================================
    // УСЛОВИЕ 5: $age > 60
    // =================================================================
    
    public function testCondition_AgeOver60_True(): void
    {
        $result = $this->service->calculate(70, false, 600.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCondition_AgeOver60_False(): void
    {
        $result = $this->service->calculate(25, false, 600.0);
        $this->assertEquals(0.0, $result);
    }

    // =================================================================
    // УСЛОВИЕ 6: $isVip (в составном || вложенного if)
    // =================================================================
    
    public function testCondition_IsVip_True_InNestedCondition(): void
    {
        $result = $this->service->calculate(25, true, 600.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCondition_IsVip_False_InNestedCondition(): void
    {
        $result = $this->service->calculate(65, false, 600.0);
        $this->assertEquals(0.10, $result);
    }
}