<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="time"] element
 */
class Time extends Input
{
    protected $validators = [
        'time',
        'required' => 'required',
        'max' => 'max',
        'min' => 'min',
    ];

    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'time');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
