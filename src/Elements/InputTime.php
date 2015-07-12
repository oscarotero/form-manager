<?php
namespace FormManager\Elements;

use FormManager\InputInterface;

class InputTime extends InputDatetime implements InputInterface
{
	protected $attributes = ['type' => 'time'];
    protected $format = 'H:i:s';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Time::validate');
    }
}
