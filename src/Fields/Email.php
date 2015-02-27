<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Email extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'email')
            ->addValidator('FormManager\\Validators\\Email::validate');
    }
}
