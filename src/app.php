<?php
require_once __DIR__ . '/../vendor/autoload.php';

use \KD\CommissionCalculator\Exception\MissingParameterException;
use \KD\CommissionCalculator\Main\CommissionCalculator;
use \KD\CommissionCalculator\Providers\Bin\BinListProvider;
use \CommissionCalculator\Validator;
use \KD\CommissionCalculator\Providers\ExchangeRate\ExchangeRatesApiProvider;

if (!isset($argv[1])) {
    throw new MissingParameterException('Missing file');
}

$commissionCalculator = new CommissionCalculator(new Validator(), new BinListProvider(),
    new ExchangeRatesApiProvider());

$rows = file($argv[1]);
foreach ($rows as $row) {
    $line = json_decode($row, true);

    echo sprintf("%s\n", $commissionCalculator->run($line));
}