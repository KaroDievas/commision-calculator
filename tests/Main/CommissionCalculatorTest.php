<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-21
 * Time: 20:46
 */

namespace KD\CommissionCalculator\tests\Main;


use CommissionCalculator\Validator;
use KD\CommissionCalculator\Main\CommissionCalculator;
use KD\CommissionCalculator\Providers\Bin\BinListProvider;
use KD\CommissionCalculator\Providers\ExchangeRate\ExchangeRatesApiProvider;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function testCorrectEUCommission()
    {
        $binListProvider = $this->getMockBuilder(BinListProvider::class)->getMock();
        $binListProvider->expects($this->any())->method('getAlpha2CountryCodeByBin')->willReturn('LT');

        $exchangeRateProvider = $this->getMockBuilder(ExchangeRatesApiProvider::class)->getMock();
        $exchangeRateProvider->expects($this->any())->method('getExchangeRateByCurrencyCode')->willReturn(0);


        $commissionCalculator = new CommissionCalculator(new Validator(), $binListProvider, $exchangeRateProvider);
        $result = $commissionCalculator->run(array(
            "bin" => "45717360",
            "amount" => "100.00",
            "currency" => "EUR"

        ));
        $this->assertEquals(1, $result);

        $result = $commissionCalculator->run(array(
            "bin" => "45717360",
            "amount" => "1000.00",
            "currency" => "EUR"

        ));
        $this->assertEquals(10, $result);

        $result = $commissionCalculator->run(array(
            "bin" => "45717360",
            "amount" => "50.00",
            "currency" => "USD"

        ));
        $this->assertEquals(0.5, $result);

        unset($commissionCalculator);
    }

    public function testCorrectNonEUCommission()
    {
        $binListProvider = $this->getMockBuilder(BinListProvider::class)->getMock();
        $binListProvider->expects($this->any())->method('getAlpha2CountryCodeByBin')->willReturn('JP');

        $exchangeRateProvider = $this->getMockBuilder(ExchangeRatesApiProvider::class)->getMock();
        $exchangeRateProvider->expects($this->any())->method('getExchangeRateByCurrencyCode')->willReturn(118.42);


        $commissionCalculator = new CommissionCalculator(new Validator(), $binListProvider, $exchangeRateProvider);
        $result = $commissionCalculator->run(array(
            "bin" => "45717360",
            "amount" => "10000.00",
            "currency" => "JPY"

        ));
        $this->assertEquals(1.69, $result);

        unset($commissionCalculator);
    }

}