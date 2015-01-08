<?php
/**
 * Trait with common methods of all child elements (elements inside the form)
 */

namespace FormManager\Traits;

use FormManager\FormElementInterface;
use FormManager\Form;

trait ChildTrait
{
    protected $parent;

    /**
     * Set the element parent
     *
     * @param FormElementInterface $parent
     *
     * @return self
     */
    public function setParent(FormElementInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Returns the element parent
     *
     * @return null|FormElementInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Returns the form element
     *
     * @return null|Form
     */
    public function getForm()
    {
        if ($this->parent) {
            return ($this->parent instanceof Form) ? $this->parent : $this->parent->getForm();
        }
    }
}
