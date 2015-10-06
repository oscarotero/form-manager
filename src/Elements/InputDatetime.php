<?php

namespace FormManager\Elements;

use FormManager\InputInterface;

class InputDatetime extends Input implements InputInterface
{
    protected $attributes = ['type' => 'datetime'];
    protected $format = 'Y-m-d\TH:i:sP';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Datetime::validate');
    }

    /**
     * @see FormManager\InputInterface
     *
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->attr('value');
        }

        if ($value instanceof \Datetime) {
            $value = $value->format($this->format);
        }

        $this->attr('value', $value);

        return $this;
    }
}
