<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Hidden extends Field
{
    public function __construct()
    {
        $this->labelPosition = static::LABEL_NONE;
        $this->datalistAllowed = false;

        $this->input = (new Elements\Input())->attr('type', 'hidden');

        parent::__construct();
    }
}
