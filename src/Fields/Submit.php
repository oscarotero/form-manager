<?php
namespace FormManager\Fields;

use FormManager\Elements;

class Submit extends Field
{
    public function __construct()
    {
        $this->labelPosition = static::LABEL_NONE;
        $this->datalistAllowed = false;

        $this->input = (new Elements\Button())
            ->attr('type', 'submit');

        parent::__construct();
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
}
