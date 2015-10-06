<?php

namespace FormManager\Elements;

use FormManager\InputInterface;

class InputColor extends Input implements InputInterface
{
    protected $attributes = ['type' => 'color'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Color::validate');
    }
}
