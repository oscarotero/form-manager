<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Password extends Input implements FormElementInterface
{
    protected $attributes = ['type' => 'password'];
}
