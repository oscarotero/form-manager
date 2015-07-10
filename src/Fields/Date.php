<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Date extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\InputDatetime())
            ->attr('type', 'date')
            ->format('Y-m-d')
            ->addValidator('FormManager\\Validators\\Date::validate');

        parent::__construct();
    }
}
