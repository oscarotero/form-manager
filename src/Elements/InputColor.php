<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputColor extends Input implements DataElementInterface
{
	protected $attributes = ['type' => 'color'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Color::validate');
    }
}
