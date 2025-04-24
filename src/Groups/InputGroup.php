<?php
declare(strict_types = 1);

namespace FormManager\Groups;

use ArrayAccess;
use ArrayIterator;
use FormManager\InputInterface;
use FormManager\NodeInterface;
use FormManager\ValidationError;
use IteratorAggregate;

/**
 * Common utilities for groups of specific inputs (like radio and submits)
 */
abstract class InputGroup implements InputInterface, ArrayAccess, IteratorAggregate
{
    protected $inputs = [];
    private $parentNode;
    private $name = '';

    public function __construct(iterable $inputs = [])
    {
        foreach ($inputs as $value => $input) {
            $this->offsetSet($value, $input);
        }
    }

    public function __clone()
    {
        foreach ($this->inputs as $k => $input) {
            $this->inputs[$k] = (clone $input)->setParentNode($this);
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->inputs);
    }

    public function offsetSet($value, $input)
    {
        $input->setAttribute('value', $value);
        $input->setName($this->name);
        $input->setParentNode($this);

        $this->inputs[$value] = $input;
    }

    public function offsetGet($value)
    {
        return $this->inputs[$value] ?? null;
    }

    public function offsetUnset($value)
    {
        unset($this->inputs[$value]);
    }

    public function offsetExists($value): bool
    {
        return isset($this->inputs[$value]);
    }

    public function setValue($value): InputInterface
    {
        foreach ($this->inputs as $input) {
            $input->setValue($value);
        }

        return $this;
    }

    public function getValue()
    {
        foreach ($this->inputs as $input) {
            $value = $input->getValue();

            if ($value !== null) {
                return $value;
            }
        }
    }

    public function isValid(): bool
    {
        foreach ($this->inputs as $input) {
            if (!$input->isValid()) {
                return false;
            }
        }

        return true;
    }

    public function getError(): ?ValidationError
    {
        foreach ($this->inputs as $input) {
            if ($error = $input->getError()) {
                return $error;
            }
        }

        return null;
    }

    public function setName(string $name): InputInterface
    {
        $this->name = $name;

        foreach ($this->inputs as $input) {
            $input->setName($name);
        }

        return $this;
    }

    public function getParentNode(): ?NodeInterface
    {
        return $this->parentNode;
    }

    public function setParentNode(NodeInterface $node): NodeInterface
    {
        $this->parentNode = $node;

        return $this;
    }

    public function __toString()
    {
        return implode("\n", $this->inputs);
    }
}
