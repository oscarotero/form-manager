<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Datetime extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'datetime')
            ->addValidator('FormManager\\Validators\\Datetime::validate');
    }
}
