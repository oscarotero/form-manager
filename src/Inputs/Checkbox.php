<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\InputInterface;

/**
 * Class representing a HTML input[type="checkbox"] element
 */
class Checkbox extends Input
{
    protected $template = '{{ input }} {{ label }}';
    protected $validators = [
        'required' => 'required',
    ];

    public function __construct(string $label = null, iterable $attributes = [])
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
        $this->error = null;

        if (
            ((string) $this->getAttribute('value') === (string) $value) ||
            filter_var($value, FILTER_VALIDATE_BOOLEAN)
        ) {
            return $this->setAttribute('checked', true);
        }

        return $this->removeAttribute('checked');
    }

    public function getValue()
    {
        return $this->getAttribute('checked') ? true : null;
    }
}
