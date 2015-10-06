<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Range extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\InputNumber())->attr('type', 'range');

        parent::__construct();
    }
}
