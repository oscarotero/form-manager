<?php

namespace FormManager\Elements;

class ErrorLabel extends Label
{
    protected $attributes = ['class' => 'error'];

    /**
     * {@inheritdoc}
     */
    public function html($html = null)
    {
        return $this->input->error();
    }
}
