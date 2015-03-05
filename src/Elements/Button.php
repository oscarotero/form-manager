<?php
namespace FormManager\Elements;

use FormManager\Traits\InputTrait;
use FormManager\DataElementInterface;

class Button extends Element implements DataElementInterface
{
    use InputTrait;

    protected $name = 'button';
    protected $close = true;
}
