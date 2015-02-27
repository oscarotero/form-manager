<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Select extends FieldContainer
{
    public function __construct()
    {
        $this->input = new Inputs\Select();
    }
}
