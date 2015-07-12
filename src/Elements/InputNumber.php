<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputNumber extends Input implements DataElementInterface
{
	protected $attributes = ['type' => 'number'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Number::validate');
    }
}
