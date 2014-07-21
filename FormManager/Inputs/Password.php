<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Password extends Input implements InputInterface
{
    protected $attributes = ['type' => 'password'];
}
