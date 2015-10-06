<?php

namespace FormManager\Fields;

use FormManager\Elements;

class Month extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputMonth();

        parent::__construct();
    }
}
