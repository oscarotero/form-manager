<?php

namespace FormManager\Fields;

use FormManager\Elements\Select;

class Select extends FieldContainer
{
    public function __construct(array $options = null)
    {
        parent::__construct(new Select());

        if ($options) {
            $this->input->options($options);
        }
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
