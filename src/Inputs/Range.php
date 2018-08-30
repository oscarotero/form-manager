<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="range"] element
 */
class Range extends Input
{
    protected $validators = [
        'number',
        'required' => 'required',
        'step' => 'step',
        'max' => 'max',
        'min' => 'min',
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
