<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Week extends Input implements InputInterface
{
    protected $attributes = ['type' => 'week'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Week::validate');
    }
}
