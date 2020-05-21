<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-21
 * Time: 18:48
 */
declare(strict_types=1);

namespace KD\CommissionCalculator\Providers\ExchangeRate;


use KD\CommissionCalculator\Providers\ProviderInterface;

class ExchangeRatesApiProvider implements ProviderInterface, ExchangeRateProviderInterface
{
    CONST PROVIDER_URL = 'https://api.exchangeratesapi.io/latest';

    /**
     * gets exchange rate
     *
     * @param $currencyCode
     * @return float
     */
    public function getExchangeRateByCurrencyCode($currencyCode): float
    {
        // or we need throw error ?
        if (empty($currencyCode)) {
            return 0;
        }

        $exchangeResults = json_decode(file_get_contents(self::PROVIDER_URL), true);

        if (isset($exchangeResults['rates']) && isset($exchangeResults['rates'][$currencyCode])) {
            return $exchangeResults['rates'][$currencyCode];
        }

        return 0;
    }
}