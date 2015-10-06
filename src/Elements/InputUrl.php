<?php

namespace FormManager\Elements;

use FormManager\InputInterface;

class InputUrl extends Input implements InputInterface
{
    protected $attributes = ['type' => 'url'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Url::validate');
    }
}
