<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Datetime extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'datetime')
            ->addValidator('FormManager\\Validators\\Datetime::validate');
    }
}
