<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Number extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'number')
            ->addValidator('FormManager\\Validators\\Number::validate');
    }
}
