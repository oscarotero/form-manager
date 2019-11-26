<?php
declare(strict_types = 1);

namespace FormManager\Groups;

use FormManager\InputInterface;
use FormManager\Inputs\Submit;

/**
 * Class representing a group of button[type="submit"] elements
 */
class SubmitGroup extends InputGroup
{
    private $value;

    public function __construct(iterable $submits = [])
    {
        foreach ($submits as &$submit) {
            if (is_string($submit)) {
                $submit = new Submit($submit);
            }
        }

        parent::__construct($submits);
    }

    public function offsetSet($value, $submit)
    {
        if (!($submit instanceof Submit)) {
            throw new InvalidArgumentException(
                sprintf('The element "%s" must be an instance of %s (%s)', $value, Submit::class, gettype($submit))
            );
        }

        parent::offsetSet($value, $submit);
    }

    public function setValue($value): InputInterface
    {
        $this->value = null;

        foreach ($this->inputs as $input) {
            if ((string) $input->getValue() === (string) $value) {
                $this->value = $value;
                break;
            }
        }

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}
