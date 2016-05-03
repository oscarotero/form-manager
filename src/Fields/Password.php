<?php

namespace FormManager\Fields;

use FormManager\Elements\Input;

class Password extends Field
{
    public function __construct()
    {
        parent::__construct((new Input())->attr('type', 'password'));
    }

    /**
     * {@inheritdoc}
     * 
     * @see RenderTrait
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        return "{$prepend}{$this->label} {$this->input} {$this->errorLabel}{$append}";
    }
}
