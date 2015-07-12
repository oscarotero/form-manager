<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputUrl extends Input implements DataElementInterface
{
	protected $attributes = ['type' => 'url'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Url::validate');
    }
}
