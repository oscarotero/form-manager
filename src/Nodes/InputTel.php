<?php
declare(strict_types = 1);

namespace FormManager\Nodes;

use Exception;

/**
 * Class representing a HTML input[type="tel"] element
 */
class InputTel extends Node
{
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'tel');
    }
}
