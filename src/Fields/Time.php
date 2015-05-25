<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Time extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'time')
            ->addValidator('FormManager\\Validators\\Time::validate');

        parent::__construct();
    }
}
