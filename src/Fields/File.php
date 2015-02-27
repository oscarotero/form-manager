<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class File extends Field
{
    public function __construct()
    {
        $this->input = new Inputs\File();
    }
}
