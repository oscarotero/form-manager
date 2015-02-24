<?php
namespace FormManager\Inputs;

use FormManager\Traits\InputTrait;
use FormManager\Element;

abstract class Input extends Element
{
    use InputTrait;

    protected $name = 'input';
}
