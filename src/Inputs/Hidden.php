<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="hidden"] element
 */
class Hidden extends Input
{
    protected $format = '{{ input }}';

    public function __construct($value = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('value', $value);
        $this->setAttribute('type', 'hidden');
    }
}
