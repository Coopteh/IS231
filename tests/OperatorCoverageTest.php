<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для проверки покрытия операторов (statement coverage)
 * Цель: выполнить каждую строку кода хотя бы один раз
 */
class OperatorCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    /**
     * Тест: покрытие ветки исключения (amount <= 0)
     */
    public function testCalculateThrowsExceptionForInvalidAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Сумма заказа должна быть больше нуля");
        
        $this->service->calculate(30, false, 0.0);
    }

    /**
     * Тест: покрытие ветки 20% скидки (amount > 1000 && isVip)
     */
    public function testCalculateTwentyPercentDiscountForVipWithLargeAmount(): void
    {
        $result = $this->service->calculate(45, true, 1500.0);
        
        $this->assertEquals(0.20, $result);
    }

    /**
     * Тест: покрытие ветки 10% скидки через age > 60 (amount > 500, age > 60, !isVip)
     */
    public function testCalculateTenPercentDiscountForSeniorWithMediumAmount(): void
    {
        $result = $this->service->calculate(65, false, 750.0);
        
        $this->assertEquals(0.10, $result);
    }

    /**
     * Тест: покрытие ветки 10% скидки через isVip (amount > 500, age <= 60, isVip)
     */
    public function testCalculateTenPercentDiscountForVipWithMediumAmount(): void
    {
        $result = $this->service->calculate(30, true, 600.0);
        
        $this->assertEquals(0.10, $result);
    }

    /**
     * Тест: покрытие дефолтной ветки (0% скидки)
     */
    public function testCalculateZeroDiscountForRegularCustomerWithSmallAmount(): void
    {
        $result = $this->service->calculate(30, false, 300.0);
        
        $this->assertEquals(0.0, $result);
    }

    /**
     * Тест: граничное значение amount = 500 (не попадает в ветку > 500)
     */
    public function testCalculateZeroDiscountAtBoundaryAmount(): void
    {
        $result = $this->service->calculate(70, false, 500.0);
        
        $this->assertEquals(0.0, $result);
    }

    /**
     * Тест: граничное значение amount = 1000 (не попадает в ветку > 1000)
     */
    public function testCalculateTenPercentAtBoundaryAmountForSenior(): void
    {
        $result = $this->service->calculate(65, false, 1000.0);
        
        $this->assertEquals(0.10, $result);
    }
}