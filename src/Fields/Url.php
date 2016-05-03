<?php

namespace FormManager\Fields;

use FormManager\Elements\Input;

class Url extends Field
{
    public function __construct()
    {
        $input = (new Input())
            ->attr('type', 'url')
            ->addValidator('FormManager\\Validators\\Url::validate');

        parent::__construct($input);
    }
}
