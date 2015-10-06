<?php

namespace FormManager\Elements;

use FormManager\InputInterface;

class InputDate extends InputDatetime implements InputInterface
{
    protected $attributes = ['type' => 'date'];
    protected $format = 'Y-m-d';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Date::validate');
    }
}
