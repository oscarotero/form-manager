<?php

namespace FormManager\Elements;

use FormManager\InputInterface;

class Button extends Input implements InputInterface
{
    protected $name = 'button';
    protected $close = true;
}
