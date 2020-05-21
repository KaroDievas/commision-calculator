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
        $binListProvider->expects($this->once())->method('getAlpha2CountryCodeByBin')->willReturn('LT');

        $exchangeRateProvider = $this->getMockBuilder(ExchangeRatesApiProvider::class)->getMock();
        $exchangeRateProvider->expects($this->once())->method('getExchangeRateByCurrencyCode')->willReturn(0);

        $data = array(
            array(

            )
        );

        $commissionCalculator = new CommissionCalculator(new Validator(), $binListProvider, $exchangeRateProvider);
        $result = $commissionCalculator->run($data);


        unset($commissionCalculator);
    }

}