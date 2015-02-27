<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Range extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'range')
            ->addValidator('FormManager\\Validators\\Number::validate');
    }
}
