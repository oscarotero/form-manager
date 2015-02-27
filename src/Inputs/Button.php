<?php
namespace FormManager\Inputs;

use FormManager\Traits\InputTrait;
use FormManager\DataElementInterface;
use FormManager\Element;

class Button extends Element implements DataElementInterface
{
    use InputTrait;

    protected $name = 'button';
    protected $close = true;
}
