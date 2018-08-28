<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\InputInterface;

/**
 * Class representing a HTML input[type="checkbox"] element
 */
class Checkbox extends Input
{
    protected $format = '{input} {label}';

    public function __construct(string $label = null, array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'checkbox');
        $this->setAttribute('value', 'on');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }

    public function setValue($value): InputInterface
    {
        if (
            ((string) $this->getAttribute('value') === (string) $value) ||
            filter_var($value, FILTER_VALIDATE_BOOLEAN)
        ) {
            $this->value = true;
            return $this->setAttribute('checked', true);
        }

        $this->value = null;
        return $this->removeAttribute('checked');
    }
}
