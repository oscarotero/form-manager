<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\Node;

/**
 * Class representing a HTML textarea element
 */
class Select extends Input
{
    const INTR_VALIDATORS = [];

    const ATTR_VALIDATORS = [
    ];

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
        $this->value = null;

        foreach ($this->getChildNodes() as $option) {
            if ($option->value == $value) {
                $this->value = $value;
                $option->selected = true;
            } else {
                $option->selected = false;
            }
        }
    }
}
