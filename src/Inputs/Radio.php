<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

use FormManager\Groups\RadioGroup;
use FormManager\InputInterface;

/**
 * Class representing a HTML input[type="radio"] element
 */
class Radio extends Input
{
    protected $validators = [
        'required' => 'required',
    ];

    protected $template = '{{ input }} {{ label }}';

    public function __construct(?string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'radio');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }

    public function setValue($value): InputInterface
    {
        $this->error = null;

        if (!empty($value) && (string) $this->getAttribute('value') === (string) $value) {
            return $this->setAttribute('checked', true);
        }

        $parent = $this->getParentNode();

        if ($parent instanceof RadioGroup) {
            if (!empty($value) && isset($parent[(string) $value])) {
                unset($this->validators['required']);
            } else {
                $this->validators['required'] = 'required';
            }
        }

        return $this->removeAttribute('checked');
    }

    public function getValue()
    {
        return $this->getAttribute('checked') ? $this->getAttribute('value') : null;
    }
}
