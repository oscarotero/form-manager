<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Date extends Input implements InputInterface
{
    protected $attributes = ['type' => 'date'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Date::validate');
    }
}
