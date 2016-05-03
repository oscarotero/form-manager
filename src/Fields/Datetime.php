<?php

namespace FormManager\Fields;

use FormManager\Elements\InputDatetime;

class Datetime extends Field
{
    public function __construct()
    {
        parent::__construct((new InputDatetime('Y-m-d\TH:i:sP'))->attr('type', 'datetime'));
    }
}
