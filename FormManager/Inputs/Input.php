<?php
namespace FormManager\Inputs;

use FormManager\Traits\ChildTrait;

use FormManager\Element;

abstract class Input extends Element
{
    use ChildTrait;

    protected $name = 'input';
    protected $validators = [];
    protected $sanitizer;
    protected $error;

    /**
	 * Magic method to create instances using the API Input::text()
	 */
    public static function __callStatic($name, $arguments)
    {
        $class = __NAMESPACE__.'\\'.ucfirst($name);

        if (class_exists($class)) {
            return new $class;
        }
    }

    /**
     * {@inheritDoc}
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
    public function error($error = null)
    {
        if ($error === null) {
            return $this->error;
        }

        $this->error = $error;

        return $this;
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
     * Adds new value validator
     *
     * @param string   $name      The validator name
     * @param callable $validator The validator function
     *
     * @return $this
     */
    public function addValidator($name, $validator)
    {
        $this->validators[$name] = $validator;

        return $this;
    }

    /**
     * Removes a validator
     *
     * @param string $name The validator name
     *
     * @return $this
     */
    public function removeValidator($name)
    {
        unset($this->validators[$name]);

        return $this;
    }

    /**
     * Executes all validators and returns whether the value is valid or not
     *
     * @return boolean
     */
    public function validate()
    {
        $this->error = null;

        foreach ($this->validators as $validator) {
            if (($error = $validator($this)) !== true) {
                $this->error = $error;

                return false;
            }
        }

        return true;
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
     * @return $this
     */
    public function check()
    {
        return $this;
    }

    /**
	 * Unchecks the input  (used in some inputs like radio/checkboxes)
	 *
	 * @return $this
	 */
    public function uncheck()
    {
        return $this;
    }
}
