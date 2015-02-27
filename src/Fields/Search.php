<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Search extends Field
{
    public function __construct()
    {
        $this->input = (new Inputs\Input())
            ->attr('type', 'search');
    }
}
