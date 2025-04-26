<?php
declare(strict_types=1);

namespace FormManager\Groups;

use ArrayAccess;
use ArrayIterator;
use Countable;
use FormManager\InputInterface;
use FormManager\NodeInterface;
use InvalidArgumentException;
use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * Class representing a collection of multiple groups
 */
class MultipleGroupCollection implements InputInterface, ArrayAccess, Countable, IteratorAggregate
{
    private $parentNode;
    private $name = '';
    private $groups = [];
    private $values = [];

    public function __construct(iterable $groups)
    {
        foreach ($groups as $key => $group) {
            if (!($group instanceof Group)) {
                throw new InvalidArgumentException(
                    sprintf('The group tagged as %s is not a %s instance', $key, Group::class)
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

    public function count(): int
    {
        return count($this->values);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->values);
    }

    public function offsetSet($name, $input): void
    {
        throw new RuntimeException(sprintf('Cannot add elements dynamically to a %s instance', self::class));
    }

    #[\ReturnTypeWillChange]
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

    public function isValid(): bool
    {
        foreach ($this->values as $input) {
            if (!$input->isValid()) {
                return false;
            }
        }

        return true;
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
