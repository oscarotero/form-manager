<?php

namespace FormManager;

use Exception;

/**
 * Class representing a HTML input element
 */
class Input extends Node
{
    const AVAILABLE_TYPES = [
        'checkbox',
        'color',
        'date',
        'datetime-local',
        'email',
        'file',
        'hidden',
        'month',
        'number',
        'password',
        'radio',
        'range',
        'search',
        'submit',
        'tel',
        'text',
        'time',
        'url',
        'week',
    ];

    protected $labels = [];

    public function __construct($type = 'text')
    {
        if (!in_array($type, self::AVAILABLE_TYPES)) {
            throw new Exception(sprintf('Invalid input type "%s"', $type));
        }

        parent::__construct('input');
        $this->setAttribute('type', $type);
    }
}
