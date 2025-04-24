<?php
declare(strict_types = 1);

namespace FormManager\Groups;

use ArrayAccess;
use ArrayIterator;
use FormManager\InputInterface;
use FormManager\NodeInterface;
use InvalidArgumentException;
use IteratorAggregate;
use Symfony\Component\Console\Input\InputOption;
use Traversable;

/**
 * Class representing a group of inputs of any type
 */
class Group implements InputInterface, ArrayAccess, IteratorAggregate
{
    private $parentNode;
    private $name = '';
    private $inputs = [];

    /**
     * @param iterable<InputInterface> $inputs
     */
    public function __construct(iterable $inputs = [])
    {
        foreach ($inputs as $name => $input) {
            $this->offsetSet((string) $name, $input);
        }
    }

    public function __clone()
    {
        foreach ($this->inputs as $k => $input) {
            $this->inputs[$k] = (clone $input)->setParentNode($this);
        }
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->inputs);
    }

    /**
     * @param $name string
     * @param $input InputInterface
     */
    public function offsetSet($name, $input): void
    {
        if (!($input instanceof InputInterface)) {
            throw new InvalidArgumentException(
                sprintf('The element "%s" must implement %s', $name, InputInterface::class)
            );
        }

        $input->setName($this->name === '' ? $name : "{$this->name}[{$name}]");
        $this->inputs[$name] = $input;
    }

    /**
     * @param $name string
     */
    public function offsetGet($name)
    {
        return $this->inputs[$name] ?? null;
    }

    /**
     * @param $name string
     */
    public function offsetUnset($name): void
    {
        unset($this->inputs[$name]);
    }

    /**
     * @param $name string
     */
    public function offsetExists($name): bool
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

    /**
     * @return array<string, mixed>
     */
    public function getValue(): array
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

    public function __toString(): string
    {
        return implode("\n", $this->inputs);
    }
}
