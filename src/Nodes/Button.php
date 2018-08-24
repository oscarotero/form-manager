<?php
declare(strict_types = 1);

namespace FormManager\Nodes;

use Exception;

/**
 * Class representing a HTML button element
 */
class Button extends Node
{
    const AVAILABLE_TYPES = [
        'button',
        'reset',
        'submit',
    ];

    public function __construct($type = 'button')
    {
        if (!in_array($type, self::AVAILABLE_TYPES)) {
            throw new Exception(sprintf('Invalid input type "%s"', $type));
        }

        parent::__construct('button');
        $this->setAttribute('type', $type);
    }
}
