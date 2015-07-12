<?php
namespace FormManager\Elements;

use FormManager\InputInterface;

class InputMonth extends InputDatetime implements InputInterface
{
    protected $attributes = ['type' => 'month'];
    protected $format = 'Y-m';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Month::validate');
    }
}
