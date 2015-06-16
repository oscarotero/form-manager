<?php
namespace FormManager\Elements;

use FormManager\TreeInterface;

/**
 * Class to manage an optgroup of a select.
 */
class Optgroup extends Fieldset
{
    protected $name = 'optgroup';

    /**
     * @see TreeInterface
     *
     * {@inheritdoc}
     */
    public function setParent(TreeInterface $parent = null)
    {
        if (!($parent instanceof Select)) {
            throw new \Exception("Optgroups only can belong to Select instances");
        }

        return parent::setParent($parent);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof Option) {
            $value->attr('value', $offset);
        } else {
            $value = Option::create($offset, $value);
        }

        parent::offsetSet($offset, $value);
    }
}
