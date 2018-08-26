<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="hidden"] element
 */
class Hidden extends Input
{
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'hidden');
    }
}
