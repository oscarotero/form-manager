<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputTime extends InputDatetime implements DataElementInterface
{
	protected $attributes = ['type' => 'time'];
    protected $format = 'H:i:s';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Time::validate');
    }
}
