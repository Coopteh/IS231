<?php
namespace Tests;

use App\DiscountService;
use PHPUnit\Framework\TestCase;

class CombinatorialCoverageTest extends TestCase
{
    private DiscountService $service;

    protected function setUp(): void
    {
        $this->service = new DiscountService();
    }

    public function testCombinatorial_AmountOver1000_True_IsVip_True(): void
    {
        $result = $this->service->calculate(25, true, 1500.0);
        $this->assertEquals(0.20, $result, 'Комбинация (T,T) должна давать 20% скидку');
    }

    public function testCombinatorial_AmountOver1000_True_IsVip_False(): void
    {
        $result = $this->service->calculate(25, false, 1500.0);
        $this->assertEquals(0.0, $result, 'Комбинация (T,F) без age>60 => 0%');
        
        $result = $this->service->calculate(65, false, 1500.0);
        $this->assertEquals(0.10, $result, 'Комбинация (T,F) с age>60 => 10%');
    }

    public function testCombinatorial_AmountOver1000_False_IsVip_True_AmountOver500(): void
    {
        $result = $this->service->calculate(25, true, 750.0);
        $this->assertEquals(0.10, $result, 'Комбинация (F,T) при amount>500 => 10%');
    }

    public function testCombinatorial_AmountOver1000_False_IsVip_True_AmountUnder500(): void
    {
        $result = $this->service->calculate(25, true, 300.0);
        $this->assertEquals(0.0, $result, 'Комбинация (F,T) при amount<=500 => 0%');
    }

    public function testCombinatorial_AmountOver1000_False_IsVip_False_AmountOver500_AgeOver60(): void
    {
        $result = $this->service->calculate(65, false, 750.0);
        $this->assertEquals(0.10, $result, '(F,F)+amount>500+age>60 => 10%');
    }

    public function testCombinatorial_AmountOver1000_False_IsVip_False_AmountOver500_AgeUnder60(): void
    {
        $result = $this->service->calculate(25, false, 750.0);
        $this->assertEquals(0.0, $result, '(F,F)+amount>500+age<=60 => 0%');
    }

    public function testCombinatorial_AmountOver1000_False_IsVip_False_AmountUnder500(): void
    {
        $result = $this->service->calculate(25, false, 300.0);
        $this->assertEquals(0.0, $result, '(F,F)+amount<=500 => 0%');
    }

    public function testNested_Condition_AgeOver60_True_IsVip_True(): void
    {
        $result = $this->service->calculate(65, true, 750.0);
        $this->assertEquals(0.10, $result, '(T,T) во вложенном условии => 10%');
    }

    public function testNested_Condition_AgeOver60_True_IsVip_False(): void
    {
        $result = $this->service->calculate(65, false, 750.0);
        $this->assertEquals(0.10, $result, '(T,F) во вложенном условии => 10%');
    }

    public function testNested_Condition_AgeOver60_False_IsVip_True(): void
    {
        $result = $this->service->calculate(25, true, 750.0);
        $this->assertEquals(0.10, $result, '(F,T) во вложенном условии => 10%');
    }

    public function testNested_Condition_AgeOver60_False_IsVip_False(): void
    {
        $result = $this->service->calculate(25, false, 750.0);
        $this->assertEquals(0.0, $result, '(F,F) во вложенном условии => 0%');
    }
    
    public function testBoundary_AmountExactly500(): void
    {
        $result = $this->service->calculate(65, false, 500.0);
        $this->assertEquals(0.0, $result, 'amount=500 (не >500) => 0%');
    }

    public function testBoundary_AmountExactly1000(): void
    {
        $result = $this->service->calculate(25, true, 1000.0);
        $this->assertEquals(0.0, $result, 'amount=1000 (не >1000) => проверка elseif');
        
        $result = $this->service->calculate(65, false, 1000.0);
        $this->assertEquals(0.10, $result, 'amount=1000 + age>60 => 10%');
    }

    public function testBoundary_AgeExactly60(): void
    {
        $result = $this->service->calculate(60, false, 750.0);
        $this->assertEquals(0.0, $result, 'age=60 (не >60) + !isVip => 0%');
        
        $result = $this->service->calculate(61, false, 750.0);
        $this->assertEquals(0.10, $result, 'age=61 (>60) => 10%');
    }
}