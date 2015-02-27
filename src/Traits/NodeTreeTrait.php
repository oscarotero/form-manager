<?php
namespace FormManager\Traits;

use FormManager\InvalidValueException;

/**
 * Trait with common methods for all nodes in the form tree.
 */
trait NodeTreeTrait
{
    protected $sanitizer;
    protected $render;
    protected $rendering = false;
    protected $validators = [];
    protected $error;
    protected $key;

    /**
     * Set the key used to calculate the path of this node.
     *
     * @param mixed $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the full path of this node
     * Used to calculate the real name of each input.
     *
     * @return null|string
     */
    public function getPath()
    {
        if (!($parent = $this->getParent())) {
            return null;
        }

        $path = $parent->getPath();

        if ($path) {
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
     * push a new validator.
     *
     * @param callable $validator
     *
     * @return $this
     */
    public function addValidator($validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     * Removes a validator.
     *
     * @param callable $validator
     *
     * @return $this
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
     * Check if the current value is valid or not.
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->validate();
    }

    /**
     * Set/Get the error message.
     *
     * @param null|string $error null to getter, string to setter
     *
     * @return null|string
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
     * Register a sanitize for the value of this input.
     *
     * @param callable $sanitizer
     *
     * @return $this
     */
    public function sanitize(callable $sanitizer)
    {
        $this->sanitizer = $sanitizer;

        return $this;
    }

    /**
     * Register a custom render function for this input.
     *
     * @param callable $render
     *
     * @return $this
     */
    public function render(callable $render)
    {
        $this->render = $render;

        return $this;
    }

    /**
     * @see FormManager\Element::toHtml
     */
    public function toHtml($prepend = '', $append = '')
    {
        if ($this->rendering) {
            return parent::toHtml($prepend, $append);
        }

        $this->rendering = true;

        if ($this->render) {
            $html = call_user_func($this->render, $this, $prepend, $append);
        } else {
            $html = $this->renderDefault($prepend, $append);
        }

        $this->rendering = false;

        return $html;
    }

    /**
     * This trait must be used only in Element.
     *
     * @see FormManager\Element
     *
     * @return null|Element
     */
    abstract public function getParent();

    /**
     * Execute the default render.
     *
     * @see FormManager\Element::toHtml
     *
     * @param string $prepend
     * @param string $append
     *
     * @return string
     */
    abstract protected function renderDefault($prepend = '', $append = '');
}
