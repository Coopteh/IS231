<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для демонстрации покрытия условий (Condition Coverage).
 * Каждое атомарное условие должно быть оценено как TRUE и как FALSE.
 */
class ConditionCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    // === Условие: $amount <= 0 ===
    public function testAmountCondition_True(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->calculate(30, false, -10); // TRUE: выбросит исключение
    }

    public function testAmountCondition_False(): void
    {
        $result = $this->service->calculate(30, false, 100); // FALSE: продолжит выполнение
        $this->assertIsFloat($result);
    }

    // === Условие: $amount > 1000 ===
    public function testAmountGreaterThan1000_True(): void
    {
        $result = $this->service->calculate(30, true, 1500); // TRUE + $isVip=true → 20%
        $this->assertEquals(0.20, $result);
    }

    public function testAmountGreaterThan1000_False(): void
    {
        $result = $this->service->calculate(30, false, 800); // FALSE → переход к elseif
        $this->assertLessThan(0.20, $result);
    }

    // === Условие: $isVip (в первом сложном условии) ===
    public function testIsVip_True_InFirstCondition(): void
    {
        $result = $this->service->calculate(30, true, 1200); // TRUE → 20%
        $this->assertEquals(0.20, $result);
    }

    public function testIsVip_False_InFirstCondition(): void
    {
        $result = $this->service->calculate(30, false, 1200); // FALSE → переход к elseif
        $this->assertNotEquals(0.20, $result);
    }

    // === Условие: $amount > 500 ===
    public function testAmountGreaterThan500_True(): void
    {
        $result = $this->service->calculate(65, false, 600); // TRUE → вход во вложенный if
        $this->assertGreaterThanOrEqual(0.0, $result);
    }

    public function testAmountGreaterThan500_False(): void
    {
        $result = $this->service->calculate(25, false, 300); // FALSE → пропуск вложенной логики
        $this->assertEquals(0.0, $result);
    }

    // === Условие: $age > 60 ===
    public function testAgeGreaterThan60_True(): void
    {
        $result = $this->service->calculate(70, false, 700); // TRUE → 10%
        $this->assertEquals(0.10, $result);
    }

    public function testAgeGreaterThan60_False(): void
    {
        $result = $this->service->calculate(40, false, 700); // FALSE → проверка $isVip
        $this->assertEquals(0.0, $result); // если и $isVip = false
    }

    // === Условие: $isVip (во вложенном условии) ===
    public function testIsVip_True_InNestedCondition(): void
    {
        $result = $this->service->calculate(40, true, 700); // TRUE → 10% (через вложенный if)
        $this->assertEquals(0.10, $result);
    }

    public function testIsVip_False_InNestedCondition(): void
    {
        $result = $this->service->calculate(40, false, 700); // FALSE + age<=60 → 0%
        $this->assertEquals(0.0, $result);
    }
}