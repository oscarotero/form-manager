<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Tel extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())->attr('type', 'tel');

        parent::__construct();
    }
}
