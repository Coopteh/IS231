<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для проверки покрытия условий (condition coverage)
 * Цель: каждое атомарное условие ($amount <= 0, $amount > 1000, $isVip, $amount > 500, $age > 60)
 * должно быть оценено как true и как false хотя бы один раз
 */
class ConditionCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    // ==================== C1: $amount <= 0 ====================
    
    public function testCondition_AmountLessOrEqualZero_True(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->calculate(30, false, -10.0); // C1 = true
    }

    public function testCondition_AmountLessOrEqualZero_False(): void
    {
        $result = $this->service->calculate(30, false, 100.0); // C1 = false
        $this->assertIsFloat($result);
    }

    // ==================== C2: $amount > 1000 ====================
    
    public function testCondition_AmountGreaterThan1000_True(): void
    {
        $result = $this->service->calculate(40, true, 1001.0); // C2 = true, C3 = true
        $this->assertEquals(0.20, $result);
    }

    public function testCondition_AmountGreaterThan1000_False(): void
    {
        $result = $this->service->calculate(40, true, 999.0); // C2 = false
        $this->assertLessThan(0.20, $result);
    }

    // ==================== C3: $isVip ====================
    
    public function testCondition_IsVip_True(): void
    {
        $result = $this->service->calculate(40, true, 1001.0); // C3 = true
        $this->assertEquals(0.20, $result);
    }

    public function testCondition_IsVip_False(): void
    {
        $result = $this->service->calculate(40, false, 1001.0); // C3 = false
        $this->assertNotEquals(0.20, $result);
    }

    // ==================== C4: $amount > 500 ====================
    
    public function testCondition_AmountGreaterThan500_True(): void
    {
        $result = $this->service->calculate(65, false, 501.0); // C4 = true
        $this->assertEquals(0.10, $result);
    }

    public function testCondition_AmountGreaterThan500_False(): void
    {
        $result = $this->service->calculate(65, false, 499.0); // C4 = false
        $this->assertEquals(0.0, $result);
    }

    // ==================== C5: $age > 60 ====================
    
    public function testCondition_AgeGreaterThan60_True(): void
    {
        $result = $this->service->calculate(61, false, 600.0); // C5 = true
        $this->assertEquals(0.10, $result);
    }

    public function testCondition_AgeGreaterThan60_False(): void
    {
        $result = $this->service->calculate(60, false, 600.0); // C5 = false
        $this->assertEquals(0.0, $result);
    }

    // ==================== Комплексные проверки условий ====================
    
    /**
     * Проверка: (C2 && C3) — оба условия истинны
     */
    public function testCondition_Combination_AmountGt1000_And_IsVip(): void
    {
        $result = $this->service->calculate(50, true, 1500.0);
        $this->assertEquals(0.20, $result);
    }

    /**
     * Проверка: (C5 || C3) внутри C4 — истинно через age
     */
    public function testCondition_Combination_AgeGt60_Or_IsVip_ThroughAge(): void
    {
        $result = $this->service->calculate(70, false, 800.0);
        $this->assertEquals(0.10, $result);
    }

    /**
     * Проверка: (C5 || C3) внутри C4 — истинно через isVip
     */
    public function testCondition_Combination_AgeGt60_Or_IsVip_ThroughVip(): void
    {
        $result = $this->service->calculate(40, true, 800.0);
        $this->assertEquals(0.10, $result);
    }

    /**
     * Проверка: (C5 || C3) — оба ложны
     */
    public function testCondition_Combination_AgeLe60_And_NotVip(): void
    {
        $result = $this->service->calculate(40, false, 800.0);
        $this->assertEquals(0.0, $result);
    }
}
