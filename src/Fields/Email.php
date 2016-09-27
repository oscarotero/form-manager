<?php

namespace FormManager\Fields;

use FormManager\Elements\Input;

class Email extends Field
{
    public function __construct()
    {
        parent::__construct(new Input());

        $this->input->attr('type', 'email');
        $this->input->addValidator(\FormManager\Validators\Email::class, 'FormManager\\Validators\\Email::validate');
    }
}
