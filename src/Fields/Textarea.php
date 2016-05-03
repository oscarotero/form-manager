<?php

namespace FormManager\Fields;

use FormManager\Elements\Textarea as TextareaElement;

class Textarea extends Field
{
    public function __construct()
    {
        parent::__construct(new TextareaElement());
    }
}
