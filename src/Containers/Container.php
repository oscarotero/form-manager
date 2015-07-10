<?php
namespace FormManager\Containers;

use FormManager\Traits\NodeTreeTrait;
use FormManager\Traits\RenderTrait;
use FormManager\DataElementInterface;
use FormManager\Elements\ElementContainer;

abstract class Container extends ElementContainer implements DataElementInterface
{
    protected $name = 'div';

    use NodeTreeTrait;
    use RenderTrait;

    public function __construct(array $children = null)
    {
        if ($children) {
            $this->add($children);
        }
    }

    /**
     * Loads a value sent by the client.
     *
     * @param mixed $value The GET/POST/FILES value
     *
     * @return $this
     */
    public function load($value = null)
    {
        if ($this->sanitizer) {
            $value = call_user_func($this->sanitizer, $value);
        }

        foreach ($this->children as $key => $child) {
            $child->load(isset($value[$key]) ? $value[$key] : null);
        }

        $this->valid = null;

        return $this;
    }

    /**
     * Set/Get values of this container.
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

        $this->valid = null;

        return $this;
    }

    /**
     * Checks whether all input values are valid.
     *
     * @return boolean
     */
    public function isValid()
    {
        if (!$this->validate()) {
            return false;
        }

        foreach ($this->children as $child) {
            if (!$child->isValid()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns all childrens contaning errors.
     *
     * @return array
     */
    public function getElementsWithErrors()
    {
        $elements = [];

        if (!$this->isValid()) {
            $elements[] = $this;
        }

        foreach ($this->children as $child) {
            if ($child instanceof Container) {
                foreach ($child->getElementsWithErrors() as $element) {
                    $elements[] = $element;
                }
            } elseif (!$child->isValid()) {
                $elements[] = $child;
            }
        }

        return $elements;
    }

    /**
     * {@inheritDoc}
     *
     * @see ElementContainer::toHtml
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        return parent::toHtml($prepend, $append);
    }
}
