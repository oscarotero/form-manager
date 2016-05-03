<?php

namespace FormManager\Fields;

use FormManager\Elements\InputRadio;

class Radio extends Field
{
    public function __construct()
    {
        parent::__construct(new InputRadio());
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
