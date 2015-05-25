<?php
namespace FormManager\Fields;

use FormManager\Traits\RenderTrait;
use FormManager\TreeInterface;
use FormManager\Elements\Label;

/**
 * Class to manage the combination of input + label.
 *
 * @property null|Label $label
 * @property null|Label $errorLabel
 */
abstract class Field implements TreeInterface
{
    use RenderTrait;

    const LABEL_NONE = 0;
    const LABEL_BEFORE = 1;
    const LABEL_AFTER = 2;

    public $input;

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
            return null;
        }

        if ($name === 'label') {
            return $this->label = new Label($this->input);
        }

        if ($name === 'errorLabel') {
            return $this->errorLabel = new Label($this->input, ['class' => 'error'], $this->input->error());
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
     * @see TreeInterface
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * {@inheritdoc}
     *
     * @see TreeInterface
     */
    public function setParent(TreeInterface $parent = null)
    {
        return $this->__call('setParent', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see TreeInterface
     */
    public function getParent()
    {
        return $this->__call('getParent', func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @see TreeInterface
     */
    public function getForm()
    {
        return $this->__call('getForm', func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        if ($this->labelPosition === static::LABEL_NONE) {
            return "{$prepend}{$this->input}{$append}";
        }

        if ($this->labelPosition === static::LABEL_BEFORE) {
            return "{$prepend}{$this->label} {$this->input} {$this->errorLabel}{$append}";
        }

        return "{$prepend}{$this->input} {$this->label} {$this->errorLabel}{$append}";
    }
}
