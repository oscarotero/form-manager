<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\InputInterface;

/**
 * Class representing a HTML textarea element
 */
class Textarea extends Input
{
    const INTR_VALIDATORS = [];

    const ATTR_VALIDATORS = [
        'maxlength',
        'minlength',
    ];

    public function __construct(string $label = null, array $attributes = [])
    {
        parent::__construct('textarea', $attributes);

        if (isset($label)) {
            $this->setLabel($label);
        }
    }

    public function setValue($value): InputInterface
    {
        $this->value = $value;
        $this->innerHTML = self::escape((string) $value);

        return $this;
    }
}
