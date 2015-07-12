<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputMonth extends InputDatetime implements DataElementInterface
{
	protected $attributes = ['type' => 'month'];
    protected $format = 'Y-m';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Month::validate');
    }
}
