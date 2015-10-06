<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Search extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())->attr('type', 'search');

        parent::__construct();
    }
}
