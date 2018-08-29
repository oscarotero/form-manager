<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Inputs\Input;
use FormManager\ValidatorFactory;
use Respect\Validation\Exceptions\NestedValidationException;
use IteratorAggregate;
use ArrayIterator;

/**
 * Class representing a validation error
 */
class ValidationError implements IteratorAggregate
{
    private $exception;

    public static function assert(Input $input): ?ValidationError
    {
        $value = $input->getValue();

        try {
            $required = ValidatorFactory::createValidator($input, ['required']);

            if ($required) {
                $required->assert($value);
            }

            if (self::isEmpty($value, $input->getAttribute('multiple'))) {
                return null;
            }

            $validators = $input->getValidators();

            if (empty($validators)) {
                return null;
            }

            ValidatorFactory::createValidator($input, $validators)->assert($value);
        } catch (NestedValidationException $exception) {
            return new static($exception);
        }

        return null;
    }

    public function __construct(NestedValidationException $exception)
    {
        $this->exception = $exception;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->exception->getMessages());
    }

    public function __toString()
    {
        return current($this->exception->getMessages());
    }

    private static function isEmpty($value, $multiple): bool
    {
        return $value === ''
            || $value === null
            || ($value === [] && $multiple);
    }

    public function setTranslator(callable $translator): self
    {
        $this->exception->setParam('translator', $translator);

        return $this;
    }

    public function getAllMessages(array $filter = null): array
    {
        if (empty($filter)) {
            return $this->exception->getMessages();
        }

        return $this->exception->findMessages($filter);
    }
}
