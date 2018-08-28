<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="week"] element
 */
class Week extends Input
{
    const INTR_VALIDATORS = [
        'week'
    ];

    const ATTR_VALIDATORS = [
        // 'step',
        'max',
        'min',
    ];
    
    public function __construct(string $label = null, array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'week');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
