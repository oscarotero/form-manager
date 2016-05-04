<?php

namespace FormManager\Fields;

use FormManager\Elements\InputNumber;

class Range extends Field
{
    public function __construct()
    {
        parent::__construct((new InputNumber())->attr('type', 'range'));
    }
}
