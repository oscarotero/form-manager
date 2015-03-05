<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Email extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'email')
            ->addValidator('FormManager\\Validators\\Email::validate');
    }
}
