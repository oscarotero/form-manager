<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Month extends Input implements InputInterface
{
    protected $attributes = ['type' => 'month'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Month::validate');
    }
}
