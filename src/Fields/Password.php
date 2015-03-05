<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Password extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'password');
    }
}
