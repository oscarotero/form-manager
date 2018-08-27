<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\InputInterface;

/**
 * Class representing a HTML input[type="radio"] element
 */
class Radio extends Input
{
    protected $format = '{input} {label}';

    public function __construct(array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'radio');
    }

    public function setValue($value): InputInterface
    {
        if (!empty($value) && (string) $this->getAttribute('value') === (string) $value) {
            $this->value = $value;
            return $this->setAttribute('checked', true);
        }

        $this->value = null;
        return $this->removeAttribute('checked');
    }
}
