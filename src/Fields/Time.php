<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Time extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'time')
            ->addValidator('FormManager\\Validators\\Time::validate');
    }
}
