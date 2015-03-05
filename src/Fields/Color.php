<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Color extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'color')
            ->addValidator('FormManager\\Validators\\Color::validate');
    }
}
