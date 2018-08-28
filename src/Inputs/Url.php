<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="url"] element
 */
class Url extends Input
{
    const INTR_VALIDATORS = [
        'url'
    ];

    const ATTR_VALIDATORS = [
        'maxlength',
        'minlength',
        'pattern',
    ];

    public function __construct(string $label = null, array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'url');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
