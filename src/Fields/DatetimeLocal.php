<?php
namespace FormManager\Fields;

use FormManager\Elements;

class DatetimeLocal extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\InputDatetime())
            ->attr('type', 'datetime-local')
            ->format('Y-m-d\TH:i:s')
            ->addValidator('FormManager\\Validators\\DatetimeLocal::validate');

        parent::__construct();
    }
}
