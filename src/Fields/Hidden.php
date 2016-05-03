<?php

namespace FormManager\Fields;

use FormManager\Elements\Input;

class Hidden extends Field
{
    public function __construct()
    {
        parent::__construct((new Input())->attr('type', 'hidden'));
    }

    /**
     * {@inheritdoc}
     * 
     * @see RenderTrait
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        return "{$prepend}{$this->input}{$this->errorLabel}{$append}";
    }
}
