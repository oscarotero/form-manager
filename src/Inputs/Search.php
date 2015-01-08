<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Search extends Input implements FormElementInterface
{
    protected $attributes = ['type' => 'search'];
}
