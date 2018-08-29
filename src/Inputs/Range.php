<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="range"] element
 */
class Range extends Input
{
    protected const INTR_VALIDATORS = [
        'number',
    ];

    protected const ATTR_VALIDATORS = [
        'step',
        'max',
        'min',
        'required',
    ];
    
    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'range');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
