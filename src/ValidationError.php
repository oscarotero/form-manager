<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Inputs\Input;
use FormManager\ValidatorFactory;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\ConstraintViolationList;
use IteratorAggregate;
use ArrayIterator;

/**
 * Class representing a validation error
 */
class ValidationError implements IteratorAggregate
{
    private $violations;

    public static function assert(Input $input): ?ValidationError
    {
        $value = $input->getValue();

        // $required = ValidatorFactory::createValidator($input, ['required']);

        // if ($required) {
        //     $required->assert($value);
        // }

        // if (self::isEmpty($value, $input->getAttribute('multiple'))) {
        //     return null;
        // }

        $constraints = ValidatorFactory::createConstraints($input);

        if (!$constraints) {
            return null;
        }

        $validator = Validation::createValidator();
        $violations = $validator->validate($value, $constraints);

        if (count($violations)) {
            return new static($violations);
        }

        return null;
    }

    public function __construct(ConstraintViolationList $violations)
    {
        $this->violations = $violations;
    }

    public function getIterator()
    {
        return $this->violations->getIterator();
    }

    public function __toString()
    {
        return $this->violations[0]->getMessage();
    }

    private static function isEmpty($value, $multiple): bool
    {
        return $value === ''
            || $value === null
            || ($value === [] && $multiple);
    }
}
