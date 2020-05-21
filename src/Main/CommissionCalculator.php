<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-21
 * Time: 18:00
 */

declare(strict_types=1);

namespace KD\CommissionCalculator\Main;


use CommissionCalculator\Validator;
use KD\CommissionCalculator\Providers\Bin\BinListProvider;
use KD\CommissionCalculator\Providers\ExchangeRate\ExchangeRatesApiProvider;
use phpDocumentor\Reflection\Types\Boolean;

class CommissionCalculator
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var BinListProvider
     */
    private $binProvider;

    /**
     * @var ExchangeRatesApiProvider
     */
    private $exchangeRateProvider;

    CONST EU_COMMISSION = 0.01;
    CONST NON_EU_COMMISSION = 0.02;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->binProvider = new BinListProvider();
        $this->exchangeRateProvider = new ExchangeRatesApiProvider();
    }

    /**
     * @throws \KD\CommissionCalculator\Exception\InvalidDataException
     */
    public function run($rows)
    {
        foreach ($rows as $row) {
            $line = json_decode($row, true);
            $this->validator->validateLine($line);

            $binCountryCode = $this->binProvider->getAlpha2CountryCodeByBin($line['bin']);

            $currency = $line['currency'];
            $exchangeRate = $this->exchangeRateProvider->getExchangeRateByCurrencyCode($currency);

            $amount = $line['amount'];

            $fixedAmount = $this->getFixedAmountByExchangeRateAndCurrencyAndAmount($exchangeRate, $currency, (float)$amount);

            $commissionFee = self::NON_EU_COMMISSION;
            if ($this->isEu($binCountryCode)) {
                $commissionFee = self::EU_COMMISSION;
            }

            echo ceil($fixedAmount * $commissionFee * 100)/100;
            print "\n";
        }
    }

    /**
     * @param $exchangeRate
     * @param $currency
     * @param $amount
     * @return float
     */
    private function getFixedAmountByExchangeRateAndCurrencyAndAmount($exchangeRate, $currency, $amount): float
    {
        if ($currency != 'EUR' || $exchangeRate > 0) {
            return $amount / $exchangeRate;
        }
        return $amount;
    }

    /**
     * @param $countryCode
     * @return bool
     */
    private function isEu($countryCode): bool
    {
        $euCountries = array(
            'AT',
            'BE',
            'BG',
            'CY',
            'CZ',
            'DE',
            'DK',
            'EE',
            'EL',
            'ES',
            'FI',
            'FR',
            'GR',
            'HR',
            'HU',
            'IE',
            'IT',
            'LT',
            'LU',
            'LV',
            'MT',
            'NL',
            'PL',
            'PT',
            'RO',
            'SE',
            'SI',
            'SK'
        );
        return in_array($countryCode, $euCountries);
    }
}