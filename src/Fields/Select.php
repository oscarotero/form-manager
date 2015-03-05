<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Select extends FieldContainer
{
    public function __construct()
    {
        $this->input = new Elements\Select();
    }
}
