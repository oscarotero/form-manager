<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Radio extends Field
{
    public function __construct()
    {
        $this->labelPosition = static::LABEL_AFTER;

        $this->input = new Elements\InputRadio();
    }
}
