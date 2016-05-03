<?php

namespace FormManager\Fields;

use FormManager\Elements\InputNumber;

class Number extends Field
{
    public function __construct()
    {
        parent::__construct((new InputNumber())->attr('type', 'number'));
    }
}
