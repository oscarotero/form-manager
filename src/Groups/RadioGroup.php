<?php
declare(strict_types = 1);

namespace FormManager\Groups;

use FormManager\Inputs\Radio;

/**
 * Class representing a group of input[type="radio"] elements
 */
class RadioGroup extends InputGroup
{
    public function __construct(iterable $radios = [])
    {
        foreach ($radios as &$radio) {
            if (is_string($radio)) {
                $radio = new Radio($radio);
            }
        }

        parent::__construct($radios);
    }

    public function offsetSet($value, $radio)
    {
        if (!($radio instanceof Radio)) {
            throw new InvalidArgumentException(
                sprintf('The element "%s" must be an instance of %s (%s)', $value, Radio::class, gettype($radio))
            );
        }

        parent::offsetSet($value, $radio);
    }
}
