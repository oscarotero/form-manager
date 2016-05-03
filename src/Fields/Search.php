<?php

namespace FormManager\Fields;

use FormManager\Elements\Input;

class Search extends Field
{
    public function __construct()
    {
        parent::__construct((new Input())->attr('type', 'search'));
    }
}
