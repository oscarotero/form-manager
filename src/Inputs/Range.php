<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="range"] element
 */
class Range extends Number
{
    public function __construct(?string $label = null, iterable $attributes = [])
    {
        parent::__construct($label, $attributes);
        $this->setAttribute('type', 'range');
    }
}
