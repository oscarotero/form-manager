<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Week extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputWeek();

        parent::__construct();
    }
}
