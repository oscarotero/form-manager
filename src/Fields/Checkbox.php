<?php
namespace FormManager\Fields;

use FormManager\FormElementInterface;
use FormManager\Inputs\Input;

class Checkbox extends Radio implements FormElementInterface
{
    public function __construct()
    {
        $this->input = Input::checkbox();
    }
}
