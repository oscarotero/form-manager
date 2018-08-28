<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="file"] element
 */
class File extends Input
{
    const INTR_VALIDATORS = [
        'file'
    ];

    const ATTR_VALIDATORS = [
        'accept',
    ];
    
    public function __construct(string $label = null, array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'file');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
