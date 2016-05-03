<?php

namespace FormManager\Fields;

use FormManager\Elements\InputFile;

class File extends Field
{
    public function __construct()
    {
        parent::__construct(new InputFile());
    }
}
