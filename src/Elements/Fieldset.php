<?php
namespace FormManager\Elements;

use FormManager\TreeInterface;

/**
 * Class to manage a fieldset
 */
class Fieldset extends ElementContainer
{
    protected $name = 'fieldset';

    /**
     * Returns the element path
     *
     * @see NodeTreeTrait
     *
     * @return string
     */
    public function getPath()
    {
        if ($this->parent) {
            return $this->parent->getPath();
        }

        return '';
    }

    /**
     * @see TreeInterface
     *
     * {@inheritdoc}
     */
    public function setParent(TreeInterface $parent = null)
    {
        $this->parent = $parent;

        //Add the options to the select
        foreach ($this->children as $offset => $value) {
            $parent->offsetSet($offset, $value);

            //Keep the parent to this
            $value->setParent($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        //Add the child to the parent
        if ($this->parent) {
            $this->parent->offsetSet($offset, $value);
        }

        //Add child to itself
        parent::offsetSet($offset, $value);
    }
}
