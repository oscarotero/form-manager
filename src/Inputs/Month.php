<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="month"] element
 */
class Month extends Input
{
    const INTR_VALIDATORS = [
        'month',
    ];

    const ATTR_VALIDATORS = [
        // 'step',
        'max',
        'min',
    ];
    
    public function __construct(string $label = null, array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'month');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
