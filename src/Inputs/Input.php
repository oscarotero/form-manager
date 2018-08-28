<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\Node;
use FormManager\InputInterface;
use FormManager\ValidatorFactory;
use FormManager\ValidationError;
use Respect\Validation\Validatable;

/**
 * Class representing a generic form input
 */
abstract class Input extends Node implements InputInterface
{
    const INTR_VALIDATORS = [];
    const ATTR_VALIDATORS = [];

    private static $idIndex = 0;

    protected $format = '{label} {input}';
    protected $labels = [];
    protected $error;

    public $label;

    public static function resetIdIndex($index = 0)
    {
        self::$idIndex = $index;
    }

    public function __get(string $name)
    {
        if ($name === 'value') {
            return $this->getValue();
        }

        return parent::__get($name);
    }

    public function __set(string $name, $value)
    {
        if ($name === 'value') {
            $this->setValue($value);
            return;
        }

        if ($name === 'id') {
            $this->setId($value);
            return;
        }

        return parent::__set($name, $value);
    }

    public function setAttribute(string $name, $value): Node
    {
        return parent::setAttribute($name, $value);
    }

    public function removeAttribute($name): Node
    {
        return parent::removeAttribute($name);
    }

    public function __toString()
    {
        if ($this->label) {
            return strtr($this->format, [
                '{label}' => (string) $this->label,
                '{input}' => parent::__toString()
            ]);
        }

        return parent::__toString();
    }

    public function createLabel(string $text, array $attributes = []): Node
    {
        $label = new Node('label', $attributes);
        $label->innerHTML = $text;

        if (!$this->getAttribute('id')) {
            $this->setAttribute('id', 'id-input-'.(++self::$idIndex));
        }

        $label->setAttribute('for', $this->getAttribute('id'));

        return $this->labels[] = $label;
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

    public function isValid(): bool
    {
        if ($this->error === null) {
            $this->error = ValidationError::assert($this) ?: false;
        }

        return $this->error === false;
    }

    public function getError(): ?ValidationError
    {
        return $this->error ?: null;
    }

    public function setValue($value): InputInterface
    {
        $this->setAttribute('value', $value);

        return $this;
    }

    public function getValue()
    {
        return $this->getAttribute('value');
    }

    public function setName(string $name): InputInterface
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    public function setLabel(string $text, array $attributes = [])
    {
        $this->label = $this->createLabel($text, $attributes);

        return $this;
    }

    public function setId(string $id): InputInterface
    {
        $this->setAttribute('id', $id);

        foreach ($this->labels as $label) {
            $label->setAttribute('for', $id);
        }

        return $this;
    }

    public function setFormat(string $format): self
    {
        $this->format = strtr($format, ['{format}' => $this->format]);

        return $this;
    }
}
