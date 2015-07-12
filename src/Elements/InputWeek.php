<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputWeek extends InputDatetime implements DataElementInterface
{
	protected $attributes = ['type' => 'week'];
    protected $format = 'Y-\WW';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Week::validate');
    }
}
