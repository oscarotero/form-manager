<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Select extends FieldContainer
{
    public function __construct(array $options = null)
    {
        $this->input = new Elements\Select();

        if ($options) {
        	$this->input->options($options);
        }
    }
}
