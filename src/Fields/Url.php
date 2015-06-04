<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Url extends Field
{
    public function __construct()
    {
        $this->input = (new Elements\Input())
            ->attr('type', 'url')
            ->addValidator('FormManager\\Validators\\Url::validate');

        parent::__construct();
    }
}
