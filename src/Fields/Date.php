<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Date extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputDate();

        parent::__construct();
    }
}
