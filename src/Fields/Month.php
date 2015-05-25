<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Month extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'month')
            ->addValidator('FormManager\\Validators\\Month::validate');

        parent::__construct();
    }
}
