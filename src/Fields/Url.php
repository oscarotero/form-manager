<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Url extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputUrl();

        parent::__construct();
    }
}
