<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Inputs\Input;
use FormManager\ValidatorFactory;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Class representing a validation error
 */
class ValidationError
{
    private $exception;

    public static function assert(Input $input): ?ValidationError
    {
        $value = $input->getValue();

        try {
            $required = ValidatorFactory::required($input);

            if ($required) {
                $required->assert($value);
            }

            if ($value !== '' && $value !== null && ($value !== [] || !$input->multiple)) {
                $input->getValidator()->assert($value);
            }
        } catch (NestedValidationException $exception) {
            return new static($exception);
        }

        return null;
    }

    public function __construct(NestedValidationException $exception)
    {
        $this->exception = $exception;
    }

    public function setTranslator(callable $translator): self
    {
        $this->exception->setParam('translator', $translator);

        return $this;
    }

    public function getFirstError(): string
    {
        $messages = $this->exception->getMessages();

        return current($messages);
    }

    public function getAllErrors(array $filter = null): array
    {
        if (empty($filter)) {
            return $this->exception->getMessages();
        }

        return $this->exception->findMessages($filter);
    }
}
