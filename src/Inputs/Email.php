<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Email extends Input implements InputInterface
{
    protected $attributes = ['type' => 'email'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Email::validate');
    }
}
