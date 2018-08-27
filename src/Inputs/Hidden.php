<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="hidden"] element
 */
class Hidden extends Input
{
    protected $format = '{input}';

    public function __construct(array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'hidden');
    }
}
