<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\Node;
use FormManager\Datalist;
use FormManager\InputInterface;
use FormManager\ValidatorFactory;
use FormManager\ValidationError;
use Symfony\Component\Validator\Constraint;

/**
 * Class representing a generic form input
 */
abstract class Input extends Node implements InputInterface
{
    private static $idIndex = 0;

    protected $validators = [];
    protected $template = '{{ label }} {{ input }}';
    protected $labels = [];
    protected $error;
    protected $errorMessages = [];

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
            return strtr($this->template, [
                '{{ label }}' => (string) $this->label,
                '{{ input }}' => parent::__toString()
            ]);
        }

        return parent::__toString();
    }

    public function createLabel(string $text, array $attributes = []): Node
    {
        $label = new Node('label', $attributes);
        $label->innerHTML = $text;

        if (!$this->getAttribute('id')) {
            $this->setAttribute('id', self::generateId('id-input'));
        }

        $label->setAttribute('for', $this->getAttribute('id'));

        return $this->labels[] = $label;
    }

    public function createDatalist(array $options, array $attributes = []): Node
    {
        $datalist = new Datalist($options, $attributes);

        if (!$datalist->getAttribute('id')) {
            $datalist->setAttribute('id', self::generateId('id-datalist'));
        }

        $this->setAttribute('list', $datalist->getAttribute('id'));

        return $datalist;
    }

    public function getConstraints(): array
    {
        $validators = [];

        foreach ($this->validators as $name => $attributes) {
            if (is_int($name)) {
                $validators[] = $attributes;
                continue;
            }

            foreach ((array) $attributes as $attribute) {
                if ($this->getAttribute($attribute)) {
                    $validators[] = $name;
                    continue;
                }
            }
        }

        return $validators;
    }

    public function addConstraint(Constraint $constraint): self
    {
        $this->validators[] = $constraint;

        return $this;
    }

    public function isValid(): bool
    {
        if ($this->error === null) {
            $this->error = ValidationError::assert($this) ?: false;
        }

        return $this->error === false;
    }

    public function setErrorMessages(array $messages): self
    {
        $this->errorMessages = $messages;

        return $this;
    }

    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function getError(): ?ValidationError
    {
        return $this->isValid() ? null : $this->error;
    }

    public function setValue($value): InputInterface
    {
        $this->error = null;
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

    public function setLabel(string $text, array $attributes = []): self
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

    public function setTemplate(string $template): self
    {
        $this->template = strtr($template, ['{{ template }}' => $this->template]);

        return $this;
    }

    private static function generateId(string $prefix): string
    {
        return sprintf('%s-%s', $prefix, ++self::$idIndex);
    }
}
