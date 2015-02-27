<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Checkbox extends Field
{
    public function __construct()
    {
    	$this->labelPosition = static::LABEL_AFTER;

        $this->input = (new Inputs\Check())
        	->attr('type', 'checkbox');
    }
}
