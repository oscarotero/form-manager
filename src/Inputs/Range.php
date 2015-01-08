<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Range extends Number implements FormElementInterface
{
    protected $attributes = ['type' => 'range'];
}
