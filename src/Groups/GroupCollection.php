<?php
declare(strict_types = 1);

namespace FormManager\Groups;

use FormManager\NodeInterface;
use FormManager\InputInterface;
use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;
use Countable;
use RuntimeException;

/**
 * Class representing a group collection of inputs
 */
class GroupCollection implements InputInterface, ArrayAccess, Countable, IteratorAggregate
{
    private $parentNode;
    private $name = '';
    private $group;
    private $values = [];

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    public function __clone()
    {
        $this->group = clone $this->group;

        foreach ($this->values as $k => $group) {
            $this->values[$k] = (clone $group)->setParentNode($this);
        }
    }

    public function count()
    {
        return count($this->values);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->values);
    }

    public function offsetSet($name, $input)
    {
        throw new RuntimeException(sprintf('Cannot add elements dinamically to a %s instance', self::class));
    }

    public function offsetGet($index)
    {
        return $this->values[$index] ?? null;
    }

    public function offsetUnset($index)
    {
        unset($this->values[$index]);
    }

    public function offsetExists($index)
    {
        return isset($this->values[$index]);
    }

    public function setValue($value): InputInterface
    {
        $this->values = [];

        foreach ((array) $value as $index => $val) {
            $group = clone $this->group;
            $group->setValue($val);
            $group->setName("{$this->name}[{$index}]");
            $this->values[] = $group;
        }

        return $this;
    }

    public function getValue()
    {
        $value = [];

        foreach ($this->values as $name => $input) {
            $value[$name] = $input->getValue();
        }

        return $value;
    }

    public function setName(string $name): InputInterface
    {
        $this->name = $name;
        $this->group->setName("{$name}[]");

        foreach ($this->values as $index => $group) {
            $group->setName("{$name}[{$index}]");
        }

        return $this;
    }

    public function getGroup(): Group
    {
        return $this->group;
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
        return implode("\n", $this->values);
    }
}
