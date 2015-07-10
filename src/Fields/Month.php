<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Month extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\InputDatetime())
            ->attr('type', 'month')
            ->format('Y-m')
            ->addValidator('FormManager\\Validators\\Month::validate');

        parent::__construct();
    }
}
