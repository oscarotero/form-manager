<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Email extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputEmail();

        parent::__construct();
    }
}
