<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Week extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'week')
            ->addValidator('FormManager\\Validators\\Week::validate');
    }
}
