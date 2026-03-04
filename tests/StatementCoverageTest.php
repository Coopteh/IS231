<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для достижения покрытия операторов (Statement Coverage)
 * Каждый оператор в DiscountService должен быть выполнен хотя бы раз
 */
class StatementCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    /**
     * Тест: покрытие оператора выброса исключения
     */
    public function testCalculate_ThrowsException_WhenAmountIsZeroOrNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Сумма заказа должна быть больше нуля");
        
        $this->service->calculate(25, false, 0);
    }

    /**
     * Тест: покрытие оператора присваивания $discount = 0.20
     */
    public function testCalculate_Returns20Percent_WhenAmountOver1000AndVip(): void
    {
        $result = $this->service->calculate(30, true, 1500.00);
        $this->assertEquals(0.20, $result);
    }

    /**
     * Тест: покрытие оператора присваивания $discount = 0.10
     */
    public function testCalculate_Returns10Percent_WhenAmountOver500AndAgeOver60(): void
    {
        $result = $this->service->calculate(65, false, 750.00);
        $this->assertEquals(0.10, $result);
    }

    /**
     * Тест: покрытие оператора return $discount (значение 0.0)
     */
    public function testCalculate_ReturnsZero_WhenNoConditionsMet(): void
    {
        $result = $this->service->calculate(25, false, 300.00);
        $this->assertEquals(0.0, $result);
    }

    /**
     * Дополнительный тест для покрытия всех путей возврата
     */
    public function testCalculate_Returns10Percent_WhenAmountOver500AndVip(): void
    {
        $result = $this->service->calculate(25, true, 750.00);
        $this->assertEquals(0.10, $result);
    }
}