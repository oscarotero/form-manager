<?php
namespace FormManager\Elements;

use FormManager\Traits\InputTrait;
use FormManager\InputInterface;

class Button extends Element implements InputInterface
{
    use InputTrait;

    protected $name = 'button';
    protected $close = true;
}
