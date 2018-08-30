<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="url"] element
 */
class Url extends Input
{
    protected $validators = [
        'url',
        'required' => 'required',
        'length' => ['minlength', 'maxlength'],
        'pattern' => 'pattern'
    ];

    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'url');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
