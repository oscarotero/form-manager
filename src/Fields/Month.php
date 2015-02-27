<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Month extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'month')
            ->addValidator('FormManager\\Validators\\Month::validate');
    }
}
