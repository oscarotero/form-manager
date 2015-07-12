<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputDatetimeLocal extends InputDatetime implements DataElementInterface
{
	protected $attributes = ['type' => 'datetime-local'];
    protected $format = 'Y-m-d\TH:i:s';

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\DatetimeLocal::validate');
    }
}
