<?php

namespace FormManager\Containers;

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
