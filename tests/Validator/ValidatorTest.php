<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-21
 * Time: 20:11
 */

namespace KD\CommissionCalculator\tests\Validator;


use CommissionCalculator\Validator;
use KD\CommissionCalculator\Exception\InvalidDataException;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private $validator;

    protected function setUp()
    {
        $this->validator = new Validator();
    }

    public function testCorrectLines()
    {
        $data = array(
            'bin' => 2646832,
            'amount' => 222,
            'currency' => 'EUR'
        );

        $this->assertNull($this->validator->validateLine($data));
    }

    public function testWrongCurrency()
    {
        $data = array(
            'bin' => 2646832,
            'amount' => 222,
            'currency' => 'EUdR'
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->validator->validateLine($data);

        $data = array(
            'bin' => 2646832,
            'amount' => -1,
            'currency' => 'EUR'
        );

    }

    public function testWrongAmount()
    {
        $data = array(
            'bin' => 2646832,
            'amount' => -1,
            'currency' => 'EUR'
        );

        $this->expectException(InvalidDataException::class);
        $this->validator->validateLine($data);
    }

    public function testWrongBin()
    {
        $data = array(
            'amount' => 9,
            'currency' => 'EUR'
        );

        $this->expectException(InvalidDataException::class);
        $this->validator->validateLine($data);
    }

    protected function tearDown()
    {
        unset($this->validator);
    }
}