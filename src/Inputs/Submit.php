<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Submit extends Input implements FormElementInterface
{
    protected $name = 'button';
    protected $close = true;
    protected $attributes = ['type' => 'submit'];
}
