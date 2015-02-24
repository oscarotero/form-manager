<?php
namespace FormManager\Containers;

use FormManager\Traits\NodeTreeTrait;
use FormManager\FormElementInterface;
use FormManager\ElementContainer;

abstract class Container extends ElementContainer implements FormElementInterface
{
    protected $name = 'div';

    use NodeTreeTrait;

    public function __construct(array $children = null)
    {
        if ($children) {
            $this->add($children);
        }
    }

    /**
     * Loads a value sent by the client.
     *
     * @param mixed $value The GET/POST value
     * @param mixed $file  The FILES value (used in input[type="file"])
     *
     * @return $this
     */
    public function load($value = null, $file = null)
    {
        if ($this->sanitizer) {
            $value = call_user_func($this->sanitizer, $value);
        }

        foreach ($this->children as $key => $child) {
            $child->load(
                isset($value[$key]) ? $value[$key] : null,
                isset($file[$key]) ? $file[$key] : null
            );
        }

        return $this;
    }

    /**
     * Set/Get values of this container
     *
     * @param null|array $value null to getter, array to setter
     *
     * @return mixed
     */
    public function val($value = null)
    {
        if ($value === null) {
            $values = [];

            foreach ($this->children as $key => $child) {
                $values[$key] = $child->val();
            }

            return $values;
        }

        foreach ($this->children as $key => $child) {
            $child->val(isset($value[$key]) ? $value[$key] : null);
        }

        return $this;
    }

    /**
     * Checks whether all input values are valid.
     *
     * @return boolean
     */
    public function isValid()
    {
        $valid = true;

        foreach ($this->children as $child) {
            if (!$child->isValid()) {
                $valid = false;
            }
        }

        if (!$this->validate()) {
            $valid = false;
        }

        return $valid;
    }

    /**
     * {@inheritDoc}
     * 
     * @see FormManager\ElementContainer::toHtml
     */
    public function renderDefault($prepend = '', $append = '')
    {
        return parent::toHtml($prepend, $append);
    }
}
