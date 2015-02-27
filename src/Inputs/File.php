<?php
namespace FormManager\Inputs;

use FormManager\Traits\InputTrait;
use FormManager\DataElementInterface;
use FormManager\Element;

class File extends Element implements DataElementInterface
{
    use InputTrait;

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

    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        return parent::load($file);
    }
}
