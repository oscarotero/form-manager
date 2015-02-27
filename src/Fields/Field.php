<?php
namespace FormManager\Fields;

use FormManager\ElementInterface;
use FormManager\TreeInterface;
use FormManager\DataTreeInterface;
use FormManager\Label;

/**
 * Class to manage the combination of input + label
 * 
 * @property null|Label $label
 * @property null|Label $errorLabel
 */
abstract class Field implements DataTreeInterface
{
    public $input;

    const LABEL_NONE = 0;
    const LABEL_BEFORE = 1;
    const LABEL_AFTER = 2;

    protected $labelPosition = 1; // LABEL_BEFORE

    /**
     * Magic method to create dinamically the label and errorLabel on $this->label and $this->errorLabel.
     *
     * @param string $name
     * 
     * @return Label|null
     */
    public function __get($name)
    {
        if ($this->labelPosition === static::LABEL_NONE) {
            throw new \Exception("No labels allowed for this field");
        }

        if ($name === 'label') {
            return $this->label = new Label($this->input);
        }

        if (($name === 'errorLabel') && ($error = $this->error())) {
            return new Label($this->input, ['class' => 'error'], $error);
        }
    }

    /**
     * Clones the input and other properties.
     */
    public function __clone()
    {
        $this->input = clone $this->input;

        if (isset($this->label)) {
            $this->label = clone $this->label;
            $this->input->removeAttr('id');
            $this->label->setInput($this->input);
        }
    }

    /**
     * Magic method to pass all undefined methods to input
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
     * Creates/edit/returns the content of the label
     *
     * @param null|string $html
     *
     * @return $this
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
     * {@inheritdoc}
     * 
     * @see DataTreeInterface
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * {@inheritdoc}
     * 
     * @see DataTreeInterface
     */
    public function setParent(TreeInterface $parent)
    {
        return $this->__call('setParent', func_get_args());
    }

    /**
     * {@inheritdoc}
     * 
     * @see DataTreeInterface
     */
    public function getParent()
    {
        return $this->__call('getParent', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see DataTreeInterface
     */
    public function load($value = null, $file = null)
    {
        return $this->__call('load', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see DataTreeInterface
     */
    public function val($value = null)
    {
        return $this->__call('val', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see DataTreeInterface
     */
    public function isValid()
    {
        return $this->__call('isValid', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see DataTreeInterface
     */
    public function error($error = null)
    {
        return $this->__call('error', func_get_args());
    }

    /**
     * @see FormManager\Element::toHtml
     */
    public function toHtml($prepend = '', $append = '')
    {
        if ($this->render) {
            return call_user_func($this->render, $this, $prepend, $append);
        }

        return $this->defaultRender($prepend, $append);
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        $label = isset($this->label) ? $this->label : '';

        if ($this->labelPosition === static::LABEL_BEFORE) {
            return "{$label} {$this->input} {$this->errorLabel}";
        }

        return "{$this->input} {$label} {$this->errorLabel}";
    }
}
