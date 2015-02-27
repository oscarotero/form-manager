<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Hidden extends Field
{
    public function __construct()
    {
    	$this->labelPosition = static::LABEL_NONE;

        $this->input = (new Inputs\Input())
            ->attr('type', 'hidden');
    }
}
