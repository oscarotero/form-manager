<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Tel extends Input implements InputInterface
{
    protected $attributes = ['type' => 'tel'];
}
