<?php
namespace App\Test;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProbe() // Вместо testItAddsTwoNumbers
    {
        $this->assertEquals(4, 2 + 2);
    }
}