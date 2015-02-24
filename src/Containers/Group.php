<?php
namespace FormManager\Containers;

use FormManager\FormElementInterface;

class Group extends Container
{
    /**
     * @see ArrayAccess
     * 
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        parent::offsetSet($offset, $value);

        $value->setKey($offset);
    }
}
