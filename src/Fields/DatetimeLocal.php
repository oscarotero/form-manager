<?php

namespace FormManager\Fields;

use FormManager\Elements\InputDatetime;

class DatetimeLocal extends Field
{
    public function __construct()
    {
        parent::__construct((new InputDatetime('Y-m-d\TH:i:s'))->attr('type', 'datetime-local'));
    }
}
