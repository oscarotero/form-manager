<?php
namespace FormManager\Inputs;

use FormManager\Traits\InputTrait;
use FormManager\InputInterface;
use FormManager\ElementContainer;
use FormManager\Option;

class Select extends ElementContainer implements InputInterface
{
    use InputTrait;

    public static $error_message = 'This value is not valid';

    protected $name = 'select';
    protected $value;
    protected $allowNewValues = false;

    public function offsetSet($offset, $value)
    {
        if ($value instanceof Option) {
            $value->attr('value', $offset);
        } else {
            $value = Option::create($offset, $value);
        }

        parent::offsetSet($offset, $value);
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
            return $this->children;
        }

        foreach ($options as $offset => $option) {
            $this->offsetSet($offset, $option);
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
                $new_values = array_keys(array_diff_key($values, $this->children));

                foreach ($new_values as $val) {
                    $this[$val] = $val;
                }
            }

            //Check/uncheck current options
            foreach ($this->children as $val => $option) {
                if (isset($values[$val])) {
                    $option->check();
                } else {
                    $option->uncheck();
                }
            }
        } else {
            //Add new value
            if ($this->allowNewValues && !isset($this->children[$value])) {
                $this[$value] = $value;
            }

            if (preg_match('/^[\d]+$/', $value)) {
                $value = intval($value);
            }

            //Check/uncheck options
            foreach ($this->children as $val => $option) {
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
                if (array_keys(array_diff_key(array_flip($value), $this->children))) {
                    $this->error(static::$error_message);

                    return false;
                }
            } elseif (!isset($this->children[$value])) {
                $this->error(static::$error_message);

                return false;
            }
        }

        return parent::validate();
    }
}
