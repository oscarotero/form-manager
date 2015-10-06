<?php

namespace FormManager\Elements;

use FormManager\Traits\InputTrait;
use FormManager\InputInterface;

class Textarea extends Element implements InputInterface
{
    use InputTrait;

    protected $name = 'textarea';
    protected $close = true;

    /**
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->html;
        }

        $this->valid = null;
        $this->html = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function html($html = null)
    {
        if ($html === null) {
            return static::escape($this->html);
        }

        return $this->val($html);
    }
}
