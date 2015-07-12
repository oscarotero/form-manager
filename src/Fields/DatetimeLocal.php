<?php
namespace FormManager\Fields;

use FormManager\Elements;

class DatetimeLocal extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputDatetimeLocal();

        parent::__construct();
    }
}
