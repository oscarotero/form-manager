<?php

namespace FormManager\Fields;

use FormManager\Elements\InputDatetime;

class Date extends Field
{
    public function __construct()
    {
        parent::__construct((new InputDatetime('Y-m-d'))->attr('type', 'date'));
    }
}
