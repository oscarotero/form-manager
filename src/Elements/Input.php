<?php

namespace FormManager\Elements;

use FormManager\Traits\InputTrait;
use FormManager\InputInterface;

class Input extends Element implements InputInterface
{
    use InputTrait;

    protected $name = 'input';
}
