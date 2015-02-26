<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Time extends Input implements InputInterface
{
    protected $attributes = ['type' => 'time'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Time::validate');
    }
}
