<?php
namespace FormManager\Inputs;

use FormManager\Traits\InputTrait;
use FormManager\DataElementInterface;
use FormManager\Element;

class Input extends Element implements DataElementInterface
{
    use InputTrait;

    protected $name = 'input';
}
