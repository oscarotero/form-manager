<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Color extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'color')
            ->addValidator('FormManager\\Validators\\Color::validate');
    }
}
