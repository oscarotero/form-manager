<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Inputs\Input;
use IteratorAggregate;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Traversable;

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

        $validator = Factory::getValidator();
        $violations = $validator->validate($input->getValue(), $constraints);

        if (count($violations)) {
            /** @phpstan-ignore-next-line */
            return new static($violations);
        }

        return null;
    }

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
    }

    public function getIterator(): Traversable
    {
        return $this->violations->getIterator();
    }

    public function __toString()
    {
        return $this->violations[0]->getMessage();
    }
}
