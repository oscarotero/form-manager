<?php
declare(strict_types = 1);

namespace FormManager\Nodes;

use Exception;

/**
 * Class representing a HTML input[type="radio"] element
 */
class InputRadio extends Node
{
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'radio');
    }
}
