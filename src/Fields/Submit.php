<?php
namespace FormManager\Fields;

use FormManager\Inputs;

class Submit extends Field
{
    public function __construct()
    {
    	$this->labelPosition = static::LABEL_NONE;

        $this->input = (new Inputs\Button())
            ->attr('type', 'submit');
    }

    /**
     * Buttons has no label, so the label text will go inside the button
     *
     * {@inheritdoc}
     */
    public function label($html = null)
    {
    	return $this->__call('html', func_get_args());
    }
}
