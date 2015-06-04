<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Range extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'range')
            ->addValidator('FormManager\\Validators\\Number::validate');

        parent::__construct();
    }
}
