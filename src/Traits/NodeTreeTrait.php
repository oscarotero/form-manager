<?php
namespace FormManager\Traits;

use FormManager\InvalidValueException;

/**
 * Trait with common methods for all elements with FormManager\DataElementInterface.
 */
trait NodeTreeTrait
{
    protected $sanitizer;
    protected $validators = [];
    protected $error;
    protected $key;

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function getPath()
    {
        if (($parent = $this->getParent())) {
            $path = $parent->getPath();

            if ($path) {
                if ($this->key !== null) {
                    return "{$path}[{$this->key}]";
                }

                return $path;
            } elseif ($this->key) {
                return $this->key;
            }
        }
    }

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function addValidator(callable $validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function removeValidator($validator)
    {
        if (($key = array_search($validator, $this->validators)) !== false) {
            unset($this->validators[$key]);
        }

        return $this;
    }

    /**
     * Executes all validators and returns whether the value is valid or not.
     *
     * @return boolean
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
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function isValid()
    {
        return $this->validate();
    }

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
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
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function sanitize(callable $sanitizer)
    {
        $this->sanitizer = $sanitizer;

        return $this;
    }
}
