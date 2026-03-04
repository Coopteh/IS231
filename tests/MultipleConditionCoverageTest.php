<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для демонстрации комбинаторного покрытия условий (Multiple Condition Coverage).
 * Проверяются ВСЕ комбинации атомарных условий внутри каждого составного выражения.
 */
class MultipleConditionCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    // =================================================================
    // Комбинаторное покрытие для: if ($amount > 1000 && $isVip)
    // 4 комбинации: TT, TF, FT, FF
    // =================================================================

    public function testFirstCondition_TT_AmountGt1000_And_IsVip(): void
    {
        // $amount > 1000 = TRUE, $isVip = TRUE → 20%
        $result = $this->service->calculate(30, true, 1500);
        $this->assertEquals(0.20, $result);
    }

    public function testFirstCondition_TF_AmountGt1000_And_NotVip(): void
    {
        // $amount > 1000 = TRUE, $isVip = FALSE → переход к elseif
        $result = $this->service->calculate(30, false, 1500);
        $this->assertNotEquals(0.20, $result);
    }

    public function testFirstCondition_FT_AmountLe1000_And_IsVip(): void
    {
        // $amount > 1000 = FALSE, $isVip = TRUE → переход к elseif
        $result = $this->service->calculate(30, true, 800);
        $this->assertNotEquals(0.20, $result);
    }

    public function testFirstCondition_FF_AmountLe1000_And_NotVip(): void
    {
        // $amount > 1000 = FALSE, $isVip = FALSE → переход к elseif
        $result = $this->service->calculate(30, false, 800);
        $this->assertNotEquals(0.20, $result);
    }

    // =================================================================
    // Комбинаторное покрытие для: if ($age > 60 || $isVip)
    // (достигается только при: $amount > 500 && !($amount > 1000 && $isVip))
    // 4 комбинации: TT, TF, FT, FF
    // =================================================================

    public function testNestedCondition_TT_AgeGt60_Or_IsVip(): void
    {
        // $age > 60 = TRUE, $isVip = TRUE → 10%
        $result = $this->service->calculate(70, true, 700);
        $this->assertEquals(0.10, $result);
    }

    public function testNestedCondition_TF_AgeGt60_Or_NotVip(): void
    {
        // $age > 60 = TRUE, $isVip = FALSE → 10%
        $result = $this->service->calculate(70, false, 700);
        $this->assertEquals(0.10, $result);
    }

    public function testNestedCondition_FT_AgeLe60_Or_IsVip(): void
    {
        // $age > 60 = FALSE, $isVip = TRUE → 10%
        $result = $this->service->calculate(40, true, 700);
        $this->assertEquals(0.10, $result);
    }

    public function testNestedCondition_FF_AgeLe60_Or_NotVip(): void
    {
        // $age > 60 = FALSE, $isVip = FALSE → 0%
        $result = $this->service->calculate(40, false, 700);
        $this->assertEquals(0.0, $result);
    }

    // =================================================================
    // Дополнительные тесты для граничных значений и исключения
    // =================================================================

    public function testBoundaryAmount_Exactly1000_WithVip(): void
    {
        // $amount > 1000 = FALSE (граница), $isVip = TRUE → elseif
        $result = $this->service->calculate(30, true, 1000);
        $this->assertNotEquals(0.20, $result);
    }

    public function testBoundaryAmount_Exactly500(): void
    {
        // $amount > 500 = FALSE (граница) → пропуск вложенного if
        $result = $this->service->calculate(70, true, 500);
        $this->assertEquals(0.0, $result);
    }

    public function testBoundaryAge_Exactly60(): void
    {
        // $age > 60 = FALSE (граница)
        $result = $this->service->calculate(60, false, 700);
        $this->assertEquals(0.0, $result);
    }
}