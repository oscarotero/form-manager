<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML textarea element
 */
class Textarea extends Input
{
    const INTR_VALIDATORS = [];

    const ATTR_VALIDATORS = [
        'maxlength',
        'minlength',
    ];

    public function __construct()
    {
        parent::__construct('textarea');
    }

    protected function setValue($value)
    {
        $this->value = $value;
        $this->innerHTML = self::escape((string) $value);
    }
}
