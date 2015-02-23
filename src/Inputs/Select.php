<?php
namespace FormManager\Inputs;

use FormManager\Option;
use FormManager\FormElementInterface;

class Select extends Input implements FormElementInterface, \ArrayAccess, \Countable
{
    public static $error_message = 'This value is not valid';

    protected $name = 'select';
    protected $close = true;
    protected $options = [];
    protected $value;
    protected $allowNewValues = false;

    public function offsetExists($offset)
    {
        return isset($this->options[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->options[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if ($value instanceof Option) {
            $value->attr('value', $offset);
        } else {
            $value = Option::create($offset, $value);
        }

        $this->options[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->options[$offset]);
    }

    public function count()
    {
        return count($this->options);
    }

    /**
     * Set/Get the available options in this select.
     *
     * @param null|array $options null to getter, array to setter
     *
     * @return mixed
     */
    public function options(array $options = null)
    {
        if ($options === null) {
            return $this->options;
        }

        foreach ($options as $value => $option) {
            $this[$value] = $option;
        }

        return $this;
    }

    /**
     * Set true to allow values non defined in the $options array
     * Useful to insert dinamically new values.
     *
     * @param boolean $allow
     *
     * @return $this
     */
    public function allowNewValues($allow = true)
    {
        $this->allowNewValues = $allow;

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

        if ($this->attr('multiple') && !is_array($value)) {
            $value = array($value);
        }

        if (is_array($value)) {
            $values = array_flip($value);

            //Add new values
            if ($this->allowNewValues) {
                $new_values = array_keys(array_diff_key($values, $this->options));

                foreach ($new_values as $val) {
                    $this[$val] = $val;
                }
            }

            //Check/uncheck current options
            foreach ($this->options as $val => $option) {
                if (isset($values[$val])) {
                    $option->check();
                } else {
                    $option->uncheck();
                }
            }
        } else {
            //Add new value
            if ($this->allowNewValues && !isset($this->options[$value])) {
                $this[$value] = $value;
            }

            //Check/uncheck options
            foreach ($this->options as $val => $option) {
                if ($val === $value) {
                    $option->check();
                } else {
                    $option->uncheck();
                }
            }
        }

        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $value = $this->val();

        if (!empty($value)) {
            if ($this->attr('multiple')) {
                if (array_keys(array_diff_key(array_flip($value), $this->options))) {
                    $this->error(static::$error_message);

                    return false;
                }
            } elseif (!isset($this->options[$value])) {
                $this->error(static::$error_message);

                return false;
            }
        }

        return parent::validate();
    }

    /**
     * {@inheritDoc}
     */
    public function html($html = null)
    {
        $html = '';

        foreach ($this->options as $option) {
            $html .= $option;
        }

        return $html;
    }
}
