<?php
namespace FormManager\Inputs;

use FormManager\Traits\ChildTrait;
use FormManager\Traits\ValidationTrait;
use FormManager\Traits\VarsTrait;
use FormManager\Element;

abstract class Input extends Element
{
    use ChildTrait;
    use ValidationTrait;
    use VarsTrait;

    protected $name = 'input';
    protected $sanitizer;

    /**
     * Magic method to create instances using the API Input::text()
     */
    public static function __callStatic($name, $arguments)
    {
        $class = __NAMESPACE__.'\\'.ucfirst($name);

        if (class_exists($class)) {
            return new $class();
        }
    }

    /**
     * {@inheritDoc}
     * @param string $name
     */
    public function attr($name = null, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $name => $value) {
                $this->attr($name, $value);
            }

            return $this;
        }

        if ($value !== null) {
            $class = 'FormManager\\Attributes\\'.ucfirst($name);

            if (class_exists($class) && method_exists($class, 'onAdd')) {
                $value = $class::onAdd($this, $value);
            }
        }

        return parent::attr($name, $value);
    }

    /**
     * {@inheritDoc}
     * @param string $name
     */
    public function removeAttr($name)
    {
        parent::removeAttr($name);

        $class = 'FormManager\\Attributes\\'.ucfirst($name);

        if (class_exists($class) && method_exists($class, 'onRemove')) {
            $class::onRemove($this);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->attr('value');
        }

        if ($this->attr('multiple') && !is_array($value)) {
            $value = array($value);
        }

        return $this->attr('value', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function id($id = null)
    {
        if ($id === null) {
            if (empty($this->attributes['id'])) {
                $this->attributes['id'] = uniqid('id_', true);
            }

            return $this->attributes['id'];
        }

        $this->attributes['id'] = $id;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sanitize(callable $sanitizer)
    {
        $this->sanitizer = $sanitizer;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        if (($sanitizer = $this->sanitizer) !== null) {
            if ($this->attr('multiple') && is_array($value)) {
                foreach ($value as &$val) {
                    $val = $sanitizer($val);
                }
            } else {
                $value = $sanitizer($value);
            }
        }

        $this->val($value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        return $this->validate();
    }

    /**
     * Checks the input (used in some inputs like radio/checkboxes)
     *
     * @return self
     */
    public function check()
    {
        return $this;
    }

    /**
     * Unchecks the input  (used in some inputs like radio/checkboxes)
     *
     * @return self
     */
    public function uncheck()
    {
        return $this;
    }
}
