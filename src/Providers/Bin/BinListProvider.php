<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-21
 * Time: 18:47
 */
declare(strict_types=1);

namespace KD\CommissionCalculator\Providers\Bin;


use KD\CommissionCalculator\Exception\InvalidDataException;
use KD\CommissionCalculator\Providers\Provider;

class BinListProvider implements Provider
{
    CONST PROVIDER_URL = 'https://lookup.binlist.net';

    /**
     * Get Alpha2 country code by bin
     *
     * @param $bin
     * @return string
     * @throws InvalidDataException
     */
    public function getAlpha2CountryCodeByBin($bin): string
    {
        $binResults = file_get_contents(sprintf('%s/%s', self::PROVIDER_URL, $bin));
        if (!$binResults) {
            throw new InvalidDataException(sprintf('Bin %s was not found', $bin));
        }

        $data = json_decode($binResults);

        return $data->country->alpha2;
    }
}