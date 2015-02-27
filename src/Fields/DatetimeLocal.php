<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class DatetimeLocal extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'datetime-local')
            ->addValidator('FormManager\\Validators\\DatetimeLocal::validate');
    }
}
