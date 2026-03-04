<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для проверки комбинаторного покрытия условий
 * Цель: протестировать все значимые комбинации атомарных условий
 * в составных логических выражениях:
 * - ($amount > 1000 && $isVip)
 * - ($age > 60 || $isVip) внутри ($amount > 500)
 */
class CombinatorialCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    // ==================== Комбинации для: ($amount > 1000 && $isVip) ====================
    
    /**
     * TT: amount > 1000 = true, isVip = true → 20%
     */
    public function testCombinatorial_AmountGt1000_True_IsVip_True(): void
    {
        $result = $this->service->calculate(45, true, 1500.0);
        $this->assertEquals(0.20, $result, 'TT: Should give 20% discount');
    }

    /**
     * TF: amount > 1000 = true, isVip = false → переход к следующей ветке
     */
    public function testCombinatorial_AmountGt1000_True_IsVip_False(): void
    {
        $result = $this->service->calculate(45, false, 1500.0);
        // Попадает в ветку amount > 500, но без VIP и age <= 60 → 0%
        $this->assertEquals(0.0, $result, 'TF: No discount without VIP or senior status');
    }

    /**
     * FT: amount > 1000 = false, isVip = true → проверяем ветку amount > 500
     */
    public function testCombinatorial_AmountGt1000_False_IsVip_True(): void
    {
        // amount = 750 (>500, но не >1000), isVip = true
        $result = $this->service->calculate(45, true, 750.0);
        $this->assertEquals(0.10, $result, 'FT: VIP with medium amount gives 10%');
    }

    /**
     * FF: amount > 1000 = false, isVip = false → базовый случай
     */
    public function testCombinatorial_AmountGt1000_False_IsVip_False(): void
    {
        $result = $this->service->calculate(45, false, 750.0);
        $this->assertEquals(0.0, $result, 'FF: No discount for regular customer with medium amount');
    }

    // ==================== Комбинации для: ($age > 60 || $isVip) внутри ($amount > 500) ====================
    
    /**
     * TT: age > 60 = true, isVip = true, amount > 500 = true → 10%
     */
    public function testCombinatorial_AgeGt60_True_IsVip_True_AmountGt500(): void
    {
        $result = $this->service->calculate(70, true, 600.0);
        $this->assertEquals(0.10, $result, 'TT: Senior VIP with medium amount gets 10%');
    }

    /**
     * TF: age > 60 = true, isVip = false, amount > 500 = true → 10% (через age)
     */
    public function testCombinatorial_AgeGt60_True_IsVip_False_AmountGt500(): void
    {
        $result = $this->service->calculate(70, false, 600.0);
        $this->assertEquals(0.10, $result, 'TF: Senior gets 10% even without VIP');
    }

    /**
     * FT: age > 60 = false, isVip = true, amount > 500 = true → 10% (через VIP)
     */
    public function testCombinatorial_AgeGt60_False_IsVip_True_AmountGt500(): void
    {
        $result = $this->service->calculate(40, true, 600.0);
        $this->assertEquals(0.10, $result, 'FT: VIP gets 10% even when not senior');
    }

    /**
     * FF: age > 60 = false, isVip = false, amount > 500 = true → 0%
     */
    public function testCombinatorial_AgeGt60_False_IsVip_False_AmountGt500(): void
    {
        $result = $this->service->calculate(40, false, 600.0);
        $this->assertEquals(0.0, $result, 'FF: No discount for regular customer with medium amount');
    }

    // ==================== Граничные и независимые комбинации ====================
    
    /**
     * Проверка независимости условий: изменение одного условия меняет результат
     * MC/DC принцип: isVip влияет на результат при фиксированных других условиях
     */
    public function testMCDC_IsVipAffectsResult_WhenAmountGt1000(): void
    {
        // Фиксируем: amount = 1500 (>1000), age = 40
        $resultWithVip = $this->service->calculate(40, true, 1500.0);
        $resultWithoutVip = $this->service->calculate(40, false, 1500.0);
        
        $this->assertEquals(0.20, $resultWithVip);
        $this->assertEquals(0.0, $resultWithoutVip);
        $this->assertNotEquals($resultWithVip, $resultWithoutVip, 
            'isVip should independently affect result when amount > 1000');
    }

    /**
     * MC/DC: age влияет на результат при фиксированных других условиях
     */
    public function testMCDC_AgeAffectsResult_WhenAmountGt500_AndNotVip(): void
    {
        // Фиксируем: amount = 700 (>500), isVip = false
        $resultSenior = $this->service->calculate(65, false, 700.0);
        $resultRegular = $this->service->calculate(40, false, 700.0);
        
        $this->assertEquals(0.10, $resultSenior);
        $this->assertEquals(0.0, $resultRegular);
        $this->assertNotEquals($resultSenior, $resultRegular,
            'age should independently affect result when amount > 500 and not VIP');
    }

    /**
     * Полная таблица истинности для внешнего условия
     */
    public function testCombinatorial_FullDecisionTable(): void
    {
        $testCases = [
            // [age, isVip, amount, expected, description]
            [30, false, 100.0, 0.0, 'Small amount, regular customer'],
            [70, false, 100.0, 0.0, 'Small amount, senior (no discount < 500)'],
            [30, true, 100.0, 0.0, 'Small amount, VIP (no discount < 500)'],
            
            [30, false, 600.0, 0.0, 'Medium amount, regular, young'],
            [70, false, 600.0, 0.10, 'Medium amount, senior'],
            [30, true, 600.0, 0.10, 'Medium amount, VIP'],
            [70, true, 600.0, 0.10, 'Medium amount, senior VIP'],
            
            [30, false, 1500.0, 0.0, 'Large amount, regular, young'],
            [70, false, 1500.0, 0.0, 'Large amount, senior, not VIP'],
            [30, true, 1500.0, 0.20, 'Large amount, VIP'],
            [70, true, 1500.0, 0.20, 'Large amount, senior VIP'],
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
