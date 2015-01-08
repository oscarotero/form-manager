<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Text extends Input implements FormElementInterface
{
    protected $attributes = ['type' => 'text'];
}
