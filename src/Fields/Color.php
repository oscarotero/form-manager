<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Color extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputColor();

        parent::__construct();
    }
}
