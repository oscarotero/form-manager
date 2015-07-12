<?php
namespace FormManager\Traits;

use FormManager\InvalidValueException;

/**
 * Trait with common methods for all elements with FormManager\ContainerInterface.
 */
trait ContainerTrait
{
    protected $sanitizer;
    protected $validators = [];
    protected $error;
    protected $valid;
    protected $key;

    /**
     * @see FormManager\ContainerInterface
     *
     * {@inheritdoc}
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @see FormManager\ContainerInterface
     *
     * {@inheritdoc}
     */
    public function getPath()
    {
        if (!($parent = $this->getParent())) {
            return;
        }

        $path = $parent->getPath();

        if ($path) {
            if (strpos($this->key, '[') !== false) {
                list($p1, $p2) = explode('[', $this->key, 2);

                return "{$path}[{$p1}][{$p2}";
            }

            if ($this->key !== null) {
                return "{$path}[{$this->key}]";
            }

            return $path;
        }

        if ($this->key) {
            return $this->key;
        }
    }

    /**
     * @see FormManager\ContainerInterface
     *
     * {@inheritdoc}
     */
    public function addValidator(callable $validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * @see FormManager\ContainerInterface
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
        $this->valid = true;

        try {
            foreach ($this->validators as $validator) {
                call_user_func($validator, $this);
            }
        } catch (InvalidValueException $exception) {
            $this->error($exception->getMessage());
            $this->valid = false;
        }

        return $this->valid;
    }

    /**
     * @see FormManager\ContainerInterface
     *
     * {@inheritdoc}
     */
    public function isValid()
    {
        if ($this->valid === null) {
            $this->validate();
        }

        return $this->valid;
    }

    /**
     * @see FormManager\ContainerInterface
     *
     * {@inheritdoc}
     */
    public function error($error = null)
    {
        if ($this->valid === null) {
            $this->validate();
        }

        if ($error === null) {
            return $this->error;
        }

        $this->error = $error;

        return $this;
    }

    /**
     * @see FormManager\ContainerInterface
     *
     * {@inheritdoc}
     */
    public function sanitize(callable $sanitizer)
    {
        $this->sanitizer = $sanitizer;

        return $this;
    }

    /**
     * Returns the element parent.
     *
     * @see FormManager\TreeInterface
     *
     * @return null|ElementInterface
     */
    abstract public function getParent();
}
