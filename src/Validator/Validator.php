<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-21
 * Time: 17:48
 */
declare(strict_types=1);

namespace CommissionCalculator;


use KD\CommissionCalculator\Exception\InvalidDataException;
use KD\CommissionCalculator\Validator\ValidatorInterface;
use Payum\ISO4217\ISO4217;

class Validator implements ValidatorInterface
{
    private $currencyValidator;

    public function __construct()
    {
        $this->currencyValidator =  new ISO4217();
    }

    /**
     * Provides basic data validation
     *
     * @param $line
     * @throws InvalidDataException
     */
    public function validateLine($line)
    {
        if (!isset($line['bin'])) {
            throw new InvalidDataException('Missing bin number or invalid');
        }

        if (!isset($line['amount']) || $line['amount'] < 0) {
            throw new InvalidDataException('Missing amount or invalid');
        }

        if (!isset($line['currency']) || !$this->currencyValidator->findByAlpha3($line['currency'])) {
            throw new InvalidDataException('Missing currency or invalid');
        }
    }
}