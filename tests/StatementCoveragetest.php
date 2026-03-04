<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

/**
 * Тесты для демонстрации покрытия операторов (Statement Coverage).
 * Каждый исполняемый оператор в методе calculate() должен быть выполнен ≥1 раза.
 */
class StatementCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    public function testAmountZeroOrNegative_ThrowsException(): void
    {
        // Выполняет оператор: throw new \InvalidArgumentException(...)
        $this->expectException(\InvalidArgumentException::class);
        $this->service->calculate(25, false, 0);
    }

    public function testVipWithLargeAmount_ExecutesFirstDiscountBranch(): void
    {
        // Выполняет оператор: $discount = 0.20;
        $result = $this->service->calculate(30, true, 1500);
        $this->assertEquals(0.20, $result);
    }

    public function testAmountBetween500And1000_WithSenior_ExecutesNestedDiscount(): void
    {
        // Выполняет оператор: $discount = 0.10; внутри вложенного if
        $result = $this->service->calculate(65, false, 750);
        $this->assertEquals(0.10, $result);
    }

    public function testNoConditionsMatch_ReturnsZeroDiscount(): void
    {
        // Выполняет оператор: return $discount; при $discount = 0.0
        // (пропускает все ветки if/elseif)
        $result = $this->service->calculate(25, false, 300);
        $this->assertEquals(0.0, $result);
    }
}