<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Datetime extends Input implements InputInterface
{
    protected $attributes = ['type' => 'datetime'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Datetime::validate');
    }
}
