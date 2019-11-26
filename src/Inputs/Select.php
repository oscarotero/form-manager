<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\InputInterface;
use FormManager\Traits\HasOptionsTrait;

/**
 * Class representing a HTML textarea element
 */
class Select extends Input
{
    use HasOptionsTrait;

    protected $validators = [
        'required' => 'required',
    ];

    private $allowNewValues = false;

    public function __construct(string $label = null, iterable $options = [], iterable $attributes = [])
    {
        parent::__construct('select', $attributes);

        if ($options) {
            $this->setOptions($options);
        }

        if (isset($label)) {
            $this->setLabel($label);
        }
    }

    public function allowNewValues(bool $allowNewValues = true): self
    {
        $this->allowNewValues = $allowNewValues;

        return $this;
    }

    public function setValue($value): InputInterface
    {
        $this->error = null;

        if ($this->allowNewValues) {
            $this->addNewValues((array) $value);
        }

        if ($this->getAttribute('multiple')) {
            $this->setMultipleValues((array) $value);
            return $this;
        }

        foreach ($this->options as $option) {
            $option->selected = (string) $option->value === (string) $value;
        }

        return $this;
    }

    public function getValue()
    {
        $values = [];

        foreach ($this->options as $option) {
            if ($option->getAttribute('selected')) {
                $values[] = $option->getAttribute('value');
            }
        }

        if ($this->getAttribute('multiple')) {
            return $values;
        }

        return $values[0] ?? null;
    }

    private function setMultipleValues(iterable $values)
    {
        $values = array_map(
            function ($value) {
                return (string) $value;
            },
            $values
        );

        foreach ($this->options as $option) {
            $option->selected = in_array((string) $option->value, $values, true);
        }
    }

    private function addNewValues(iterable $values)
    {
        foreach ($values as $value) {
            foreach ($this->options as $option) {
                if ((string) $option->value === (string) $value) {
                    continue 2;
                }
            }

            $this->appendChild($this->createOption($value));
        }
    }
}
