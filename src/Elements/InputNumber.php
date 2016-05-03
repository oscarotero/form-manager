<?php

namespace FormManager\Elements;

use FormManager\InputInterface;

class InputNumber extends Input implements InputInterface
{
    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Number::validate');
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

        if (is_string($value) && preg_match('/^-?\d+(\.\d+)?$/', $value, $match)) {
            $value = empty($match[1]) ? intval($value) : floatval($value);
        } elseif ($value === '') {
            $value = null;
        }

        $this->attr('value', $value);

        return $this;
    }
}
