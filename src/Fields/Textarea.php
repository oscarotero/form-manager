<?php

namespace FormManager\Fields;

use FormManager\Elements\Textarea;

class Textarea extends Field
{
    public function __construct()
    {
        parent::__construct(new Textarea());
    }
}
