<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="week"] element
 */
class Week extends Input
{
    protected $validators = [
        'week',
        'required' => 'required',
        'max' => 'max',
        'min' => 'min',
    ];

    public function __construct(?string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'week');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
