<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Url extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'url')
            ->addValidator('FormManager\\Validators\\Url::validate');
    }
}
