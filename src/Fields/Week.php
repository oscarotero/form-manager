<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Week extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'week')
            ->addValidator('FormManager\\Validators\\Week::validate');

        parent::__construct();
    }
}
