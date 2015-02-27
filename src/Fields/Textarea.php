<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Textarea extends Field
{
    public function __construct()
    {
        $this->input = new Inputs\Textarea();
    }
}
