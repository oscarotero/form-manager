<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputDate extends InputDatetime implements DataElementInterface
{
	protected $attributes = ['type' => 'date'];
    protected $format = 'Y-m-d';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Date::validate');
    }
}
