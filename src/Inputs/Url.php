<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Url extends Input implements InputInterface
{
    protected $attributes = ['type' => 'url'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Url::validate');
    }
}
