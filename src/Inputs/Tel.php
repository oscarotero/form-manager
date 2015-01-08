<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Tel extends Input implements FormElementInterface
{
    protected $attributes = ['type' => 'tel'];
}
