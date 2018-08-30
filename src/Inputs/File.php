<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="file"] element
 */
class File extends Input
{
    protected $validators = [
        'file',
        'required' => 'required',
        'accept' => 'accept',
    ];

    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'file');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
