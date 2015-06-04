<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Hidden extends Field
{
    public function __construct()
    {
        $this->labelPosition = static::LABEL_NONE;

        $this->input = (new Elements\Input())
            ->attr('type', 'hidden');

        parent::__construct();
    }
}
