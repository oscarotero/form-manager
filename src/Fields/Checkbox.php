<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Checkbox extends Field
{
    public function __construct()
    {
        $this->labelPosition = static::LABEL_AFTER;

        $this->input = new Elements\InputCheckbox();

        parent::__construct();
    }
}
