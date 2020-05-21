<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-21
 * Time: 20:46
 */

namespace KD\CommissionCalculator\tests\Main;


use KD\CommissionCalculator\Main\CommissionCalculator;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    private $commissionCalculator;

    protected function setUp()
    {
        $this->commissionCalculator = new CommissionCalculator();
    }

}