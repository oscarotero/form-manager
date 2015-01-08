<?php
namespace FormManager\Fields;

use FormManager\Traits\ChildTrait;
use FormManager\Label;
use FormManager\FormElementInterface;
use FormManager\Traits\VarsTrait;

/**
 * @property null|Label $label
 * @property null|Label $errorLabel
 */
class Field implements FormElementInterface
{
    use ChildTrait;
    use VarsTrait;

    public $input;

    protected $render;
    protected $rendering = false;

    /**
     * Magic method to create new instances using the API Field::text()
     */
    public static function __callStatic($name, $arguments)
    {
        $class = __NAMESPACE__.'\\'.ucfirst($name);

        if (class_exists($class)) {
            if (isset($arguments[0])) {
                return new $class($arguments[0]);
            }

            return new $class();
        }

        $input = 'FormManager\\Inputs\\'.ucfirst($name);

        if (class_exists($input)) {
            return new static(new $input());
        }
    }

    public function __construct(FormElementInterface $input = null)
    {
        if ($input) {
            $this->input = $input;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * {@inheritDoc}
     */
    public function __call($name, $arguments)
    {
        call_user_func_array([$this->input, $name], $arguments);

        return $this;
    }

    /**
     * Clones the field and its content
     */
    public function __clone()
    {
        $this->input = clone $this->input;

        if (isset($this->label)) {
            $this->label = clone $this->label;
            $this->label->setInput($this->input);
        }
    }

    /**
     * Magic method to create dinamically the label and errorLabel on $this->label and $this->errorLabel
     */
    public function __get($name)
    {
        if ($name === 'label') {
            return $this->label = new Label($this->input);
        }

        if (($name === 'errorLabel') && ($error = $this->error())) {
            return new Label($this->input, ['class' => 'error'], $error);
        }
    }

    /**
     * Creates/edit/returns the label associated with the input
     *
     * @param null|string $html Null to get the label html, string to create/edit the label content
     *
     * @return self
     */
    public function label($html = null)
    {
        if ($html === null) {
            return $this->label->html();
        }

        $this->label->html($html);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function error($error = null)
    {
        if ($error === null) {
            return $this->input->error($error);
        }

        $this->input->error($error);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function attr($name = null, $value = null)
    {
        if (($value !== null) || (is_array($name))) {
            $this->input->attr($name, $value);

            return $this;
        }

        return $this->input->attr($name);
    }

    /**
     * {@inheritDoc}
     */
    public function removeAttr($name)
    {
        $this->input->removeAttr($name);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        $this->input->load($value, $file);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sanitize(callable $sanitizer)
    {
        $this->input->sanitize($sanitizer);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render(callable $render)
    {
        $this->render = $render;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->input->val();
        }

        $this->input->val($value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        return $this->input->isValid();
    }

    /**
     * {@inheritDoc}
     */
    public function toHtml()
    {
        if ($this->render && !$this->rendering) {
            $this->rendering = true;
            $html = call_user_func($this->render, $this);
            $this->rendering = false;

            return $html;
        }

        $label = isset($this->label) ? $this->label : null;

        return "{$label} {$this->input} {$this->errorLabel}";
    }

    /**
     * {@inheritDoc}
     */
    public function setParent(FormElementInterface $parent)
    {
        $this->input->setParent($parent);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return $this->input->getParent();
    }
}
