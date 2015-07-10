<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Week extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\InputDatetime())
            ->attr('type', 'week')
            ->format('Y-\WW')
            ->addValidator('FormManager\\Validators\\Week::validate');

        parent::__construct();
    }
}
