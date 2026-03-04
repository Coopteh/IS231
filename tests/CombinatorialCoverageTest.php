<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для достижения комбинаторного покрытия условий
 * Все возможные комбинации значений атомарных условий
 */
class CombinatorialCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    // =================================================================
    // КОМБИНАЦИИ для: if ($amount > 1000 && $isVip)
    // =================================================================
    
    public function testCombinatorial_AmountOver1000_True_IsVip_True(): void
    {
        $result = $this->service->calculate(30, true, 1500.0);
        $this->assertEquals(0.20, $result, '20% скидка для VIP при заказе >1000');
    }

    public function testCombinatorial_AmountOver1000_True_IsVip_False(): void
    {
        $result = $this->service->calculate(30, false, 1500.0);
        $this->assertEquals(0.0, $result);
    }

    public function testCombinatorial_AmountOver1000_False_IsVip_True(): void
    {
        $result = $this->service->calculate(30, true, 800.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCombinatorial_AmountOver1000_False_IsVip_False(): void
    {
        $result = $this->service->calculate(30, false, 800.0);
        $this->assertEquals(0.0, $result);
    }

    // =================================================================
    // КОМБИНАЦИИ для: if ($age > 60 || $isVip) [внутри elseif]
    // =================================================================
    
    public function testCombinatorial_AgeOver60_True_IsVip_True_WithinElseIf(): void
    {
        $result = $this->service->calculate(70, true, 600.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCombinatorial_AgeOver60_True_IsVip_False_WithinElseIf(): void
    {
        $result = $this->service->calculate(70, false, 600.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCombinatorial_AgeOver60_False_IsVip_True_WithinElseIf(): void
    {
        $result = $this->service->calculate(25, true, 600.0);
        $this->assertEquals(0.10, $result);
    }

    public function testCombinatorial_AgeOver60_False_IsVip_False_WithinElseIf(): void
    {
        $result = $this->service->calculate(25, false, 600.0);
        $this->assertEquals(0.0, $result);
    }

    // =================================================================
    // Граничные значения (ИСПРАВЛЕНО)
    // =================================================================
    
    /**
     * Граничное значение: amount = 1000.0
     * $amount > 1000 → false, но $amount > 500 → true
     * Поэтому выполняется вложенное условие с isVip=true → 10%
     */
    public function testBoundary_AmountExactly1000(): void
    {
        $result = $this->service->calculate(30, true, 1000.0);
        $this->assertEquals(0.10, $result, 'При amount=1000 и isVip=true срабатывает вложенное условие → 10%');
    }

    /**
     * Граничное значение: amount = 1000.0 без скидки
     */
    public function testBoundary_AmountExactly1000_NoDiscount(): void
    {
        $result = $this->service->calculate(30, false, 1000.0);
        $this->assertEquals(0.0, $result, 'При amount=1000, age<=60 и !isVip скидка не применяется');
    }

    public function testBoundary_AmountExactly500(): void
    {
        $result = $this->service->calculate(70, false, 500.0);
        $this->assertEquals(0.0, $result);
    }

    public function testBoundary_AgeExactly60(): void
    {
        $result = $this->service->calculate(60, false, 600.0);
        $this->assertEquals(0.0, $result);
    }

    public function testFullCombinatorial_Matrix(): void
    {
        $testCases = [
            [30, true,  1500.0, 0.20, 'VIP + сумма>1000 → 20%'],
            [30, false, 1500.0, 0.0,  'Не VIP + сумма>1000 → 0%'],
            [70, true,  600.0,  0.10, 'Возраст>60 + VIP + сумма>500 → 10%'],
            [70, false, 600.0,  0.10, 'Возраст>60 + сумма>500 → 10%'],
            [25, true,  600.0,  0.10, 'VIP + сумма>500 → 10%'],
            [25, false, 600.0,  0.0,  'Обычный + сумма>500 → 0%'],
            [25, false, 300.0,  0.0,  'Обычный + сумма<500 → 0%'],
        ];

        foreach ($testCases as [$age, $isVip, $amount, $expected, $description]) {
            $result = $this->service->calculate($age, $isVip, $amount);
            $this->assertEquals(
                $expected, 
                $result, 
                sprintf("Failed: %s (age=%d, vip=%s, amount=%.2f)", 
                    $description, $age, $isVip ? 'true' : 'false', $amount)
            );
        }
    }
}