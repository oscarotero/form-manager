<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\Node;
use FormManager\ValidatorFactory;
use Respect\Validation\Validatable;

/**
 * Class representing a generic form input
 */
abstract class Input extends Node
{
    const INTR_VALIDATORS = [];
    const ATTR_VALIDATORS = [];

    private static $idIndex = 0;
    protected $value;
    public $label;

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

    public function setLabel(string $text, array $attributes)
    {
        $this->label = new Node('label');
        $this->label->innerHTML = $text;
        $this->label->setAttributes($attributes);

        if (!$this->getAttribute('id')) {
            $this->setAttribute('id', 'id-input-'.(++self::$idIndex));
        }

        $this->label->setAttribute('for', $this->getAttribute('id'));

        return $this;
    }

    public function getValidator(): Validatable
    {
        $validators = static::INTR_VALIDATORS;

        foreach (static::ATTR_VALIDATORS as $name) {
            if ($this->getAttribute($name)) {
                $validators[] = $name;
            }
        }

        return ValidatorFactory::createValidator($this, $validators);
    }

    public function isValid()
    {
        $value = $this->value;

        if ($value === null || $value === '' || $value === []) {
            return !$this->required;
        }

        return $this->getValidator()->validate($value);
    }

    protected function setValue($value)
    {
        $this->value = $value;
        $this->setAttribute('value', $value);
    }
}
