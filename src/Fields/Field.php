<?php

namespace FormManager\Fields;

use FormManager\Traits\RenderTrait;
use FormManager\InputInterface;
use FormManager\ElementInterface;
use FormManager\FieldInterface;
use FormManager\Elements;
use FormManager\Elements\Label;
use FormManager\Elements\Datalist;

/**
 * Class to manage the combination of an input with other elements.
 */
abstract class Field implements FieldInterface
{
    use RenderTrait;

    public $input;
    public $label;
    public $errorLabel;
    public $datalist;

    protected function __construct(InputInterface $input)
    {
        $this->input = $input;
        $this->label = new Elements\Label($this->input);
        $this->errorLabel = new Elements\ErrorLabel($this->input);
        $this->datalist = new Elements\Datalist($this->input);
        $this->wrapper = new Elements\Div();
    }

    /**
     * Clones the input and other properties.
     */
    public function __clone()
    {
        $this->input = clone $this->input;

        if ($this->label) {
            $this->input->removeLabel($this->label);
            $this->label = clone $this->label;
            $this->label->setInput($this->input);
        }

        if ($this->errorLabel) {
            $this->input->removeLabel($this->errorLabel);
            $this->errorLabel = clone $this->errorLabel;
            $this->errorLabel->setInput($this->input);
        }

        if ($this->datalist) {
            $this->datalist = clone $this->datalist;
            $this->datalist->setInput($this->input);
        }

        if ($this->wrapper) {
            $this->wrapper = clone $this->wrapper;
        }
    }

    /**
     * Magic method to pass all undefined methods to input.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $return = call_user_func_array([$this->input, $name], $arguments);

        if ($return === $this->input) {
            return $this;
        }

        return $return;
    }

    /**
     * Creates/edit/returns the content of the label.
     *
     * @param null|string $html
     *
     * @return self
     */
    public function label($html = null)
    {
        if (empty($this->label)) {
            throw new \BadMethodCallException('No label allowed for this field');
        }

        if ($html === null) {
            return $this->label->html();
        }

        $this->label->html($html);

        return $this;
    }

    /**
     * Adds html attributes to the label
     *
     * @param array $attrs
     *
     * @return self
     */
    public function attrLabel(array $attrs)
    {
        if (empty($this->label)) {
            throw new \BadMethodCallException('No label allowed for this field');
        }

        $this->label->attr($attrs);

        return $this;
    }

    /**
     * Adds html attributes to the wrapper
     *
     * @param array $attrs
     *
     * @return self
     */
    public function attrWrapper(array $attrs)
    {
        if (empty($this->wrapper)) {
            throw new \BadMethodCallException('No wrapper allowed for this field');
        }

        $this->wrapper->attr($attrs);

        return $this;
    }

    /**
     * Creates/edit/returns the content of the datalist associated with the input.
     *
     * @param null|array $options
     *
     * @return self|array
     */
    public function datalist(array $options = null)
    {
        if (empty($this->datalist)) {
            throw new \BadMethodCallException('No datalist allowed for this field');
        }

        if ($options === null) {
            return $this->datalist->options();
        }

        $this->datalist->options($options);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function attr($name = null, $value = null)
    {
        return $this->__call('attr', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function removeAttr($name)
    {
        $this->input->removeAttr($name);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function id($id = null)
    {
        return $this->__call('id', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function setParent(ElementInterface $parent = null)
    {
        $this->input->setParent($parent);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function getParent()
    {
        return $this->input->getParent();
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function getForm()
    {
        return $this->input->getForm();
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function setKey($key)
    {
        $this->input->setKey($key);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function getPath()
    {
        return $this->input->getPath();
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function addValidator(callable $validator)
    {
        $this->input->addValidator($validator);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function removeValidator($validator)
    {
        $this->input->removeValidator($validator);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function sanitize(callable $sanitizer)
    {
        $this->input->sanitize($sanitizer);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function load($value = null)
    {
        $this->input->load($value);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function val($value = null)
    {
        return $this->__call('val', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function validate()
    {
        return $this->input->validate();
    }

    /**
     * {@inheritdoc}
     *
     * @see FieldInterface
     */
    public function error($error = null)
    {
        return $this->__call('error', func_get_args());
    }

    /**
     * {@inheritdoc}
     * 
     * @see RenderTrait
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        return "{$prepend}{$this->label} {$this->input}{$this->datalist} {$this->errorLabel}{$append}";
    }
}
