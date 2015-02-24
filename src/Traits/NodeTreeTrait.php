<?php
namespace FormManager\Traits;

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
     * Adds new value validator.
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
     * Removes a validator.
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
     * Executes all validators and returns whether the value is valid or not.
     *
     * @return boolean
     */
    public function validate()
    {
        $this->error = null;

        foreach ($this->validators as $validator) {
            if (($error = $validator($this)) !== true) {
                $this->error($error);

                return false;
            }
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
        if ($this->render && !$this->rendering) {
            $this->rendering = true;
            $html = call_user_func($this->render, $this);
            $this->rendering = false;

            return $html;
        }

        return $this->renderDefault($prepend, $append);
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
