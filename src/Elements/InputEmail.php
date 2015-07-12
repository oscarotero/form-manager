<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputEmail extends Input implements DataElementInterface
{
	protected $attributes = ['type' => 'email'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Email::validate');
    }
}
