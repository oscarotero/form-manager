<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Date extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'date')
            ->addValidator('FormManager\\Validators\\Date::validate');
    }
}
