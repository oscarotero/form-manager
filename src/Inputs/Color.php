<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Color extends Input implements InputInterface
{
    protected $attributes = ['type' => 'color'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Color::validate');
    }
}
