<?php
declare(strict_types = 1);

namespace FormManager\Groups;

use ArrayAccess;
use ArrayIterator;
use Countable;
use FormManager\InputInterface;
use FormManager\NodeInterface;
use IteratorAggregate;
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

        foreach ($this->values as $index => $input) {
            $this->values[$index] = (clone $input)->setParentNode($this);
        }
    }

    public function count(): int
    {
        return count($this->values);
    }


    public function getIterator(): \Traversable
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

    public function offsetUnset($index): void
    {
        unset($this->values[$index]);
    }

    public function offsetExists($index): bool
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

    public function isValid(): bool
    {
        foreach ($this->values as $group) {
            if (!$group->isValid()) {
                return false;
            }
        }

        return true;
    }

    public function setName(string $name): InputInterface
    {
        $this->name = $name;
        $this->group->setName("{$name}[]");

        foreach ($this->values as $index => $input) {
            $input->setName("{$name}[{$index}]");
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
