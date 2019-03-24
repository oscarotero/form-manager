<?php
declare(strict_types = 1);

namespace FormManager\Groups;

use FormManager\NodeInterface;
use FormManager\InputInterface;
use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;
use InvalidArgumentException;

/**
 * Class representing a group of inputs of any type
 */
class Group implements InputInterface, ArrayAccess, IteratorAggregate
{
    private $parentNode;
    private $name = '';
    private $inputs = [];

    public function __construct(iterable $inputs = [])
    {
        foreach ($inputs as $name => $input) {
            $this->offsetSet($name, $input);
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

    public function offsetSet($name, $input)
    {
        if (!($input instanceof InputInterface)) {
            throw new InvalidArgumentException(
                sprintf('The element "%s" must implement %s', $name, InputInterface::class)
            );
        }

        $input->setName($this->name === '' ? $name : "{$this->name}[{$name}]");
        $this->inputs[$name] = $input;
    }

    public function offsetGet($name)
    {
        return $this->inputs[$name] ?? null;
    }

    public function offsetUnset($name)
    {
        unset($this->inputs[$name]);
    }

    public function offsetExists($name)
    {
        return isset($this->inputs[$name]);
    }

    public function setValue($value): InputInterface
    {
        $value = (array) $value;

        foreach ($this->inputs as $name => $input) {
            $input->setValue($value[$name] ?? null);
        }

        return $this;
    }

    public function getValue()
    {
        $value = [];

        foreach ($this->inputs as $name => $input) {
            $value[$name] = $input->getValue();
        }

        return $value;
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

    public function setName(string $name): InputInterface
    {
        $this->name = $name;

        foreach ($this->inputs as $name => $input) {
            $input->setName($this->name === '' ? $name : "{$this->name}[{$name}]");
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
