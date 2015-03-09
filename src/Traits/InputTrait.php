<?php
namespace FormManager\Traits;

/**
 * Class with common methods for all inputs with DataElementInterface.
 */
trait InputTrait
{
    use NodeTreeTrait;

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
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
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function load($value = null)
    {
        if ($this->sanitizer === null) {
            $this->val($value);

            return $this;
        }

        if ($this->attr('multiple') && is_array($value)) {
            foreach ($value as &$val) {
                $val = call_user_func($this->sanitizer, $val);
            }
        } else {
            $value = call_user_func($this->sanitizer, $value);
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
     * Calculate the input name on print.
     *
     * {@inheritdoc}
     */
    protected function attrToHtml()
    {
        $name = $this->getPath();

        if ($this->attr('multiple')) {
            $name .= '[]';
        }

        $this->attr('name', $name);

        return parent::attrToHtml();
    }

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function attr($name = null, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->attr($k, $v);
            }

            return $this;
        }

        if ($value !== null) {
            $class = 'FormManager\\Attributes\\'.ucfirst($name);

            if (class_exists($class) && method_exists($class, 'onAdd')) {
                $value = $class::onAdd($this, $value);
            }
        }

        return parent::attr($name, $value);
    }
}
