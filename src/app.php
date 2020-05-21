<?php
require_once __DIR__ . '/../vendor/autoload.php';

use \KD\CommissionCalculator\Exception\MissingParameterException;

if (!isset($argv[1])) {
    throw new MissingParameterException('Missing file');
}

$commissionCalculator = new \KD\CommissionCalculator\Main\CommissionCalculator($argv[1]);
$commissionCalculator->run();