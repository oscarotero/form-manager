<?php
namespace FormManager\Inputs;

use FormManager\InvalidValueException;
use FormManager\Traits\InputTrait;
use FormManager\InputInterface;
use FormManager\ElementContainer;
use FormManager\Option;

class Select extends ElementContainer implements InputInterface
{
    use InputTrait;

    protected $name = 'select';
    protected $value;
    protected $allowNewValues = false;

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Select::validate');
    }

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

        foreach ($this->children as $option) {
            $option->uncheck();
        }

        if (is_array($value)) {
            $this->value = $this->valArray($value);
        } elseif (is_object($value)) {
            throw new InvalidValueException('Value must be an array or string');
        } else {
            $this->value = $this->valPlain($value);
        }

        return $this;
    }

    private function valArray($value)
    {
        $value = array_keys(array_flip($value));

        //check the selected values
        foreach ($value as $val) {
            if (!isset($this->children[$val])) {
                if (!$this->allowNewValues) {
                    continue;
                }

                $this[$val] = $val;
            }

            $this->children[$val]->check();
        }

        return $value;
    }

    private function valPlain($value)
    {
        if (preg_match('/^[\d]+$/', $value)) {
            $value = intval($value);
        }

        //check the selected values
        if ($this->allowNewValues && !isset($this->children[$value])) {
            $this[$value] = $value;
            $this->children[$value]->check();
        } elseif (isset($this->children[$value])) {
            $this->children[$value]->check();
        }

        return $value;
    }
}
