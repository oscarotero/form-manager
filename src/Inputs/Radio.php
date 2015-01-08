<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Radio extends Checkbox implements FormElementInterface
{
    protected $attributes = ['type' => 'radio'];
}
