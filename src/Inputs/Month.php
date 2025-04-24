<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="month"] element
 */
class Month extends Input
{
    protected $validators = [
        'month',
        'required' => 'required',
        'max' => 'max',
        'min' => 'min',
    ];

    public function __construct(?string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'month');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
