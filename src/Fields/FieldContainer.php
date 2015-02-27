<?php
namespace FormManager\Fields;

use FormManager\Element;
use Iterator;
use ArrayAccess;
use Countable;

/**
 * Class that extends Field and manage Inputs extending ElementContainer (for example: select).
 */
abstract class FieldContainer extends Field implements Iterator, ArrayAccess, Countable
{
    /**
     * Returns the current element.
     *
     * @see Iterator
     *
     * @return null|Element
     */
    public function current()
    {
        return $this->input->current();
    }

    /**
     * Returns the key of the current element.
     *
     * @see Iterator
     *
     * @return integer|null
     */
    public function key()
    {
        return $this->input->key();
    }

    /**
     * Move forward to next element.
     *
     * @see Iterator
     *
     * @return null|Element
     */
    public function next()
    {
        return $this->input->next();
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @see Iterator
     *
     * @return null|Element
     */
    public function rewind()
    {
        return $this->input->rewind();
    }

    /**
     * Checks if current position is valid.
     *
     * @see Iterator
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->input->valid();
    }

    /**
     * Whether an offset exists.
     *
     * @see ArrayAccess
     *
     * @param mixed $offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->input->offsetExists($offset);
    }

    /**
     * Offset to retrieve.
     *
     * @see ArrayAccess
     *
     * @param mixed $offset
     *
     * @return boolean
     */
    public function offsetGet($offset)
    {
        return $this->input->offsetGet($offset);
    }

    /**
     * Offset to set.
     *
     * @see ArrayAccess
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        return $this->input->offsetSet($offset, $value);
    }

    /**
     * Offset to unset.
     *
     * @see ArrayAccess
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        return $this->input->offsetUnset($offset);
    }

    /**
     * Count the children of the element.
     *
     * @see Countable
     *
     * @return integer
     */
    public function count()
    {
        return $this->input->count();
    }
}
