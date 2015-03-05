<?php
namespace FormManager\Elements;

use FormManager\Traits\InputTrait;
use FormManager\DataElementInterface;

class Input extends Element implements DataElementInterface
{
    use InputTrait;

    protected $name = 'input';
}
