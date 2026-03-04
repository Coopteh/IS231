<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;


class StatementCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }


    public function testCalculate_ThrowsException_WhenAmountIsZeroOrNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Сумма заказа должна быть больше нуля");
        
        $this->service->calculate(25, false, 0);
    }


    public function testCalculate_Returns20Percent_WhenAmountOver1000AndVip(): void
    {
        $result = $this->service->calculate(30, true, 1500.00);
        $this->assertEquals(0.20, $result);
    }


    public function testCalculate_Returns10Percent_WhenAmountOver500AndAgeOver60(): void
    {
        $result = $this->service->calculate(65, false, 750.00);
        $this->assertEquals(0.10, $result);
    }


    public function testCalculate_ReturnsZero_WhenNoConditionsMet(): void
    {
        $result = $this->service->calculate(25, false, 300.00);
        $this->assertEquals(0.0, $result);
    }

    
    public function testCalculate_Returns10Percent_WhenAmountOver500AndVip(): void
    {
        $result = $this->service->calculate(25, true, 750.00);
        $this->assertEquals(0.10, $result);
    }
}