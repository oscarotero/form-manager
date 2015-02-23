<?php
namespace FormManager\Traits;

use FormManager\Label;

/**
 * Class with common methods for all inputs
 * 
 * @property null|Label $label
 * @property null|Label $errorLabel
 */
trait InputTrait
{
    use NodeTreeTrait;

    protected $labelBefore = true;

    /**
     * This trait must be used only in Element
     * 
     * @see FormManager\Element
     */
    abstract public function attr($name = null, $value = null);

    /**
     * Magic method to create dinamically the label and errorLabel on $this->label and $this->errorLabel.
     * 
     * @return Label|null
     */
    public function __get($name)
    {
        if ($name === 'label') {
            return $this->label = new Label($this);
        }

        if (($name === 'errorLabel') && ($error = $this->error())) {
            return new Label($this, ['class' => 'error'], $error);
        }
    }

    /**
     * Clones the input and other properties
     */
    public function __clone()
    {
        if (isset($this->label)) {
            $this->label = clone $this->label;
            $this->label->setInput($this);
        }
    }

    /**
     * Get/Set the value of this input
     * 
     * @param mixed $value
     * 
     * @return mixed
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
     * Set/Get/Generates an id for this element
     * 
     * @param null|string $id
     * 
     * @return mixed
     */
    public function id($id = null)
    {
        if ($id === null) {
            if (!$this->attr('id')) {
                $this->attr('id', uniqid('id_', true));
            }

            return $this->attr('id');
        }

        $this->attr('id', $id);

        return $this;
    }

    /**
     * Load the raw data for this input
     * 
     * @param mixed $value The value to load
     * @param mixed $file  The file value (used only in inputs of type "file")
     * 
     * @return $this
     */
    public function load($value = null, $file = null)
    {
        if ($this->sanitizer !== null) {
            if ($this->attr('multiple') && is_array($value)) {
                foreach ($value as &$val) {
                    $val = call_user_func($this->sanitizer, $val);
                }
            } else {
                $value = call_user_func($this->sanitizer, $value);
            }
        }

        $this->val($value);

        return $this;
    }

    /**
     * Checks the input (used in some inputs like radio/checkboxes).
     *
     * @return $this
     */
    public function check()
    {
        return $this;
    }

    /**
     * Unchecks the input  (used in some inputs like radio/checkboxes).
     *
     * @return $this
     */
    public function uncheck()
    {
        return $this;
    }

    /**
     * Creates/edit/returns the label associated with the input.
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
     */
    public function renderDefault($prepend = '', $append = '')
    {
        $label = isset($this->label) ? $this->label : null;
        $html = parent::toHtml($prepend, $append);

        if ($this->labelBefore) {
            return "{$label} {$html} {$this->errorLabel}";
        } else {
            return "{$html} {$label} {$this->errorLabel}";
        }
    }
}
