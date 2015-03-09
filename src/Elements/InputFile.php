<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputFile extends Input implements DataElementInterface
{
    protected $attributes = ['type' => 'file'];
    protected $value;

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\File::validate');
    }

    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->value;
        }

        $this->value = $value;

        return $this;
    }
}
