<?php
namespace FormManager\Fields;

use FormManager\Elements;

class DatetimeLocal extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'datetime-local')
            ->addValidator('FormManager\\Validators\\DatetimeLocal::validate');
    }
}
