<?php

namespace FormManager\Elements;

use FormManager\ElementInterface;
use FormManager\Fields\Form;

/**
 * Class to manage a fieldset.
 */
class Fieldset extends ElementContainer
{
    protected $name = 'fieldset';

    /**
     * @see ElementInterface
     *
     * {@inheritdoc}
     */
    public function setParent(ElementInterface $parent = null)
    {
        if (!($parent instanceof Form)) {
            throw new \Exception('Fieldset only can belong to Form instances');
        }

        $this->parent = $parent;

        foreach ($this->children as $child) {
            $child->setParent($parent);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        //Add child to itself
        parent::offsetSet($offset, $value);

        //Add the child to the parent
        if ($this->parent) {
            $this->parent->offsetSet($offset, $value);
        }
    }
}
