<?php

namespace FormManager\Fields;

use FormManager\Elements\InputCheckbox;

class Checkbox extends Field
{
    public function __construct()
    {
        parent::__construct(new InputCheckbox());
    }

    /**
     * {@inheritdoc}
     * 
     * @see RenderTrait
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        return "{$prepend}{$this->input} {$this->label} {$this->errorLabel}{$append}";
    }
}
