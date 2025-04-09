<?php
declare(strict_types = 1);

namespace FormManager\Tests;

use FormManager\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FactoryTest extends TestCase
{
    public function testGetValidator()
    {
        $this->assertInstanceOf(ValidatorInterface::class, Factory::getValidator());
    }

    public function testSetValidator()
    {
        $validator = Validation::createValidator();

        Factory::setValidator($validator);

        $this->assertSame($validator, Factory::getValidator());
    }
}
