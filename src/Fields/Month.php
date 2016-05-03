<?php

namespace FormManager\Fields;

use FormManager\Elements\InputDatetime;

class Month extends Field
{
    public function __construct()
    {
        parent::__construct((new InputDatetime('Y-m'))->attr('type', 'month'));
    }
}
