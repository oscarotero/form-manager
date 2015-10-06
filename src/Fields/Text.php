<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Text extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())->attr('type', 'text');

        parent::__construct();
    }
}
