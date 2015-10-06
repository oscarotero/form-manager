<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Number extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputNumber();

        parent::__construct();
    }
}
