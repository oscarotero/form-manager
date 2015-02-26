<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class DatetimeLocal extends Input implements InputInterface
{
    protected $attributes = ['type' => 'datetime-local'];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\DatetimeLocal::validate');
    }
}
