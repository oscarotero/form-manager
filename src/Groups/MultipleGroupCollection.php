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
use InvalidArgumentException;

/**
 * Class representing a collection of multiple groups
 */
class MultipleGroupCollection implements InputInterface, ArrayAccess, Countable, IteratorAggregate
{
    private $parentNode;
    private $name = '';
    private $groups = [];
    private $values = [];

    public function __construct(array $groups)
    {
        foreach ($groups as $key => $group) {
            if (!($group instanceof Group)) {
                throw new InvalidArgumentException(
                    sprintf('The group tagged as %s is not a %s intance', $key, Group::class)
                );
            }
        }

        $this->groups = $groups;
    }

    public function __clone()
    {
        foreach ($this->groups as $k => $group) {
            $this->groups[$k] = (clone $group)->setParentNode($this);
        }

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
            $key = $val['type'] ?? null;

            if (!isset($key) || !isset($this->groups[$key])) {
                continue;
            }

            $group = clone $this->groups[$key];
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

        foreach ($this->groups as $index => $group) {
            $group->setName("{$name}[]");
        }

        foreach ($this->values as $index => $group) {
            $group->setName("{$name}[{$index}]");
        }

        return $this;
    }

    public function getGroups(): array
    {
        return $this->groups;
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
