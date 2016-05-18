<?php

namespace FormManager\Fields;

class Choose extends Container
{
    protected $value;

    public static $error_message = 'This value is not valid';

    /**
     * @see ArrayAccess
     *
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $value->val($offset);

        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function load($value = null)
    {
        $this->val($value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->value;
        }

        $this->value = $value;

        foreach ($this as $v => $input) {
            if ($v == $value) {
                $input->attr('checked', true);
            } else {
                $input->removeAttr('checked');
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $value = $this->val();

        if (!empty($value) && !isset($this[$value])) {
            $this->error(static::$error_message);

            return false;
        }

        return parent::validate();
    }
}
