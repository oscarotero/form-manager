<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Time extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\InputDatetime())
            ->attr('type', 'time')
            ->format('H:i:s')
            ->addValidator('FormManager\\Validators\\Time::validate');

        parent::__construct();
    }
}
