<?php
namespace FormManager\Elements;

use FormManager\InputInterface;

class InputNumber extends Input implements InputInterface
{
	protected $attributes = ['type' => 'number'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Number::validate');
    }
}
