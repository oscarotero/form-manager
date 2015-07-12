<?php
namespace FormManager\Elements;

use FormManager\InputInterface;

class InputEmail extends Input implements InputInterface
{
    protected $attributes = ['type' => 'email'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Email::validate');
    }
}
