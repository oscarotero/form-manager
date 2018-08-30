<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="datetime-local"] element
 */
class DatetimeLocal extends Input
{
    protected $validators = [
        'datetimeLocal',
        'required' => 'required',
        'max' => 'max',
        'min' => 'min',
    ];
    
    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'datetime-local');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
