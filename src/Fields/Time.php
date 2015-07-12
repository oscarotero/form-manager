<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Time extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputTime();

        parent::__construct();
    }
}
