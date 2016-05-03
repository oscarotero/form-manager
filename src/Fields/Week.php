<?php

namespace FormManager\Fields;

use FormManager\Elements\InputDatetime;

class Week extends Field
{
    public function __construct()
    {
        parent::__construct((new InputDatetime('Y-\WW'))->attr('type', 'week'));
    }
}
