<?php
namespace FormManager\Fields;

use FormManager\Elements;

class File extends Field
{
    public function __construct()
    {
        $this->input = new Elements\InputFile();
    }
}
