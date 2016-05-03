<?php

namespace FormManager\Fields;

use FormManager\Elements\Button;

class Submit extends Field
{
    public function __construct()
    {
        parent::__construct((new Button())->attr('type', 'submit'));
    }

    /**
     * Buttons has no label, so the label text will go inside the button.
     *
     * {@inheritdoc}
     */
    public function label($html = null)
    {
        return $this->__call('html', func_get_args());
    }

    /**
     * {@inheritdoc}
     * 
     * @see RenderTrait
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        return "{$prepend} {$this->input} {$append}";
    }
}
