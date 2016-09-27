<?php

namespace FormManager\Fields;

use FormManager\Elements\Input;

class Color extends Field
{
    public function __construct()
    {
        parent::__construct(new Input());

        $this->input->attr('type', 'color');
        $this->input->addValidator(\FormManager\Validators\Color::class, 'FormManager\\Validators\\Color::validate');
    }
}
