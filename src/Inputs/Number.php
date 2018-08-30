<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="number"] element
 */
class Number extends Input
{
    protected $validators = [
        'number',
        'required' => 'required',
        'max' => 'max',
        'min' => 'min',
        'step' => 'step',
    ];
    
    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'number');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
