<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\Node;

/**
 * Class representing a HTML textarea element
 */
class Select extends Input
{
    public function __construct(array $options = [])
    {
        parent::__construct('select');

        foreach ($options as $value => $label) {
            $option = new Node('option');
            $option->setAttribute('value', $value);
            $option->innerHTML = $label;

            $this->appendChild($option);
        }
    }

    protected function setValue($value)
    {
        if ($this->getAttribute('multiple')) {
            return $this->setMultipleValues((array) $value);
        }

        $this->value = null;

        foreach ($this->getChildNodes() as $option) {
            if ((string) $option->value === (string) $value) {
                $this->value = $option->value;
                $option->selected = true;
            } else {
                $option->selected = false;
            }
        }
    }

    protected function setMultipleValues(array $values)
    {
        $this->value = [];

        $values = array_map(
            function ($value) {
                return (string) $value;
            },
            $values
        );

        foreach ($this->getChildNodes() as $option) {
            if (in_array((string) $option->value, $values, true)) {
                $option->selected = true;
                $this->value[] = $option->value;
            } else {
                $option->selected = false;
            }
        }
    }
}
