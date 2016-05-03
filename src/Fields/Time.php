<?php

namespace FormManager\Fields;

use FormManager\Elements\InputDateTime;

class Time extends Field
{
    public function __construct()
    {
        parent::__construct((new InputDatetime('H:i:s'))->attr('type', 'time'));
    }
}
