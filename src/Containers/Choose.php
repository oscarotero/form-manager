<?php
namespace FormManager\Containers;

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
        if ($value instanceof Container) {
            throw new \InvalidArgumentException("This element only accepts inputs");
        }

        $value->val($offset);

        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function load($value = null)
    {
        $this->val($value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->value;
        }

        $this->value = $value;

        foreach ($this as $v => $input) {
            if ($v == $value) {
                $input->check();
            } else {
                $input->uncheck();
            }
        }

        $this->valid = null;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $this->valid = true;
        $value = $this->val();

        if (!empty($value) && !isset($this[$value])) {
            $this->error(static::$error_message);
            return $this->valid = false;
        }

        return parent::validate();
    }
}
