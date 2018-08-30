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
        $constraints = ValidatorFactory::createConstraints($input);

        if (empty($constraints)) {
            return null;
        }

        $validator = Validation::createValidator();
        $violations = $validator->validate($input->getValue(), $constraints);

        if (count($violations)) {
            return new static($violations);
        }

        return null;
    }

    public function __construct(ConstraintViolationListInterface $violations)
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
}
