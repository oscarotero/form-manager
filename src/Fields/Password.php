<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Password extends Field
{
    public function __construct()
    {
        $this->datalistAllowed = false;

        $this->input = (new Elements\Input())->attr('type', 'password');

        parent::__construct();
    }
}
