<?php
declare(strict_types = 1);

namespace FormManager\Nodes;

/**
 * Class representing a HTML textarea element
 */
class Select extends Node
{
    private $value;

    protected $labels = [];

    public function __construct(array $options)
    {
        parent::__construct('select');

        foreach ($options as $value => $label) {
            $option = new Node('option');
            $option->setAttribute('value', $value);
            $option->innerHTML = $label;

            $this->appendChild($option);
        }
    }

    public function __get(string $name)
    {
        if ($name === 'value') {
            return $this->value;
        }

        return parent::__get($name);
    }

    public function __set(string $name, $value)
    {
        if ($name === 'value') {
            $this->setValue($value);
            return;
        }

        return parent::__set($name, $value);
    }

    private function setValue($value)
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
