<?php

namespace FormManager\Traits;

use FormManager\InvalidValueException;

/**
 * Trait with common methods to sanitize, validate and store errors.
 */
trait ValidateTrait
{
    protected $error;
    protected $validators = [];
    protected $sanitizer;

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function sanitize(callable $sanitizer)
    {
        $this->sanitizer = $sanitizer;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function addValidator(callable $validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function removeValidator($validator)
    {
        if (($key = array_search($validator, $this->validators)) !== false) {
            unset($this->validators[$key]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function validate()
    {
        $this->error = null;

        try {
            foreach ($this->validators as $validator) {
                call_user_func($validator, $this);
            }
        } catch (InvalidValueException $exception) {
            $this->error($exception->getMessage());

            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
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
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function load($value = null)
    {
        if ($this->sanitizer === null) {
            $this->val($value === null ? '' : $value);

            return $this;
        }

        $value = call_user_func($this->sanitizer, $value);
        $this->val($value === null ? '' : $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->attr('value');
        }

        $this->attr('value', $value);

        return $this;
    }

    /**
     * Check an attribute before add it.
     * 
     * @param string $name
     * @param mixed  $value
     * 
     * @return mixed
     */
    private function attrToValidator($name, $value)
    {
        $class = 'FormManager\\Attributes\\'.ucfirst($name);

        if (class_exists($class) && method_exists($class, 'onAdd')) {
            $value = $class::onAdd($this, $value);
        }

        return $value;
    }

    /**
     * Required method to load/return values.
     * 
     * @see ElementInterface
     */
    abstract public function attr($name = null, $value = null);
}
