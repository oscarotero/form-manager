<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="color"] element
 */
class Color extends Input
{
    protected $validators = [
        'color',
        'required' => 'required',
    ];

    public function __construct(?string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'color');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
