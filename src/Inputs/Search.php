<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="search"] element
 */
class Search extends Input
{
    protected $validators = [
        'required' => 'required',
        'length' => ['minlength', 'maxlength'],
        'pattern' => 'pattern',
    ];
    
    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'search');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
