<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Datetime extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\InputDatetime())
            ->attr('type', 'datetime')
            ->format('Y-m-d\TH:i:sP')
            ->addValidator('FormManager\\Validators\\Datetime::validate');

        parent::__construct();
    }
}
