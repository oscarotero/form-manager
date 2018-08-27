<?php
declare(strict_types = 1);

namespace FormManager\Groups;

use FormManager\NodeInterface;
use FormManager\InputInterface;
use FormManager\Inputs\Radio;
use ArrayAccess;

/**
 * Class representing a group of input[type="radio"] elements
 */
class RadioGroup implements InputInterface
{
    private $parentNode;
    private $name = '';
    private $value;
    private $radios = [];

    public function __construct(array $radios = [])
    {
        foreach ($radios as $value => $input) {
            if (is_string($input)) {
                $input = (new Radio())->setLabel($input);
            }

            $this->offsetSet($value, $input);
        }
    }

    public function offsetSet($value, $radio)
    {
        if (!($radio instanceof Radio)) {
            throw new InvalidArgumentException(
                sprintf('The element "%s" must be an instance of %s (%s)', $value, Radio::class, gettype($radio))
            );
        }

        $radio->setAttribute('value', $value);
        $radio->setName($this->name);

        $this->radios[$value] = $radio;
    }

    public function offsetGet($value)
    {
        return $this->radios[$value] ?? null;
    }

    public function offsetUnset($value)
    {
        unset($this->radios[$value]);
    }

    public function offsetExists($value)
    {
        return isset($this->radios[$value]);
    }

    public function setValue($value): InputInterface
    {
        $this->value = null;

        foreach ($this->radios as $radio) {
            if ((string) $radio->value === (string) $value) {
                $this->radio = $radio->value;
                $radio->checked = true;
            } else {
                $radio->checked = false;
            }
        }

        return $this;
    }

    public function setName(string $name): InputInterface
    {
        $this->name = $name;

        foreach ($this->radios as $radio) {
            $radio->setName($name);
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
        return implode("\n", $this->radios);
    }
}
