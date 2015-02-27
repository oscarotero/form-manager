<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Number extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'number')
            ->addValidator('FormManager\\Validators\\Number::validate');
    }
}
