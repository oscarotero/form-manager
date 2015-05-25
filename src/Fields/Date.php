<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Date extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'date')
            ->addValidator('FormManager\\Validators\\Date::validate');

        parent::__construct();
    }
}
