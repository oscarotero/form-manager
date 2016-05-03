<?php

namespace FormManager\Fields;

use FormManager\Elements\Input;

class Text extends Field
{
    public function __construct()
    {
        parent::__construct((new Input())->attr('type', 'text'));
    }
}
