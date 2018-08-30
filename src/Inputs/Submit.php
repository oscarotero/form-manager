<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML button[type="submit"] element
 */
class Submit extends Input
{
    protected $template = '{{ input }}';

    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('button', $attributes);
        $this->setAttribute('type', 'submit');

        if (isset($label)) {
            $this->innerHTML = $label;
        }
    }
}
