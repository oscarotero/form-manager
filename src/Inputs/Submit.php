<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML button[type="submit"] element
 */
class Submit extends Input
{
    public function __construct()
    {
        parent::__construct('button');
        $this->setAttribute('type', 'submit');
    }
}
