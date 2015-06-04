<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Textarea extends Field
{
    public function __construct()
    {
        $this->input = new Elements\Textarea();

        parent::__construct();
    }
}
