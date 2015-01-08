<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Hidden extends Input implements FormElementInterface
{
    protected $attributes = ['type' => 'hidden'];
}
