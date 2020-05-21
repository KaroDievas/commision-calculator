<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-21
 * Time: 20:55
 */

namespace KD\CommissionCalculator\Validator;


interface ValidatorInterface
{
    public function validateLine($line);
}