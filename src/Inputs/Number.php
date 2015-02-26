<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Number extends Input implements InputInterface
{
    protected $attributes = ['type' => 'number'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Number::validate');
    }
}
