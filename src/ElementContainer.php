<?php
namespace FormManager;

use Iterator;
use ArrayAccess;
use Countable;

/**
 * Class to manage an html element that contains other elements.
 */
class ElementContainer extends Element implements Iterator, ArrayAccess, Countable
{
    protected $close = true;
    protected $children = [];

    /**
     * Magic method to clone the elements.
     */
    public function __clone()
    {
        foreach ($this->children as $key => $child) {
            $this->children[$key] = clone $child;
            $this->children[$key]->setParent($this);
        }
    }

    /**
     * Returns the index of an element.
     *
     * @param Element $child
     *
     * @return mixed
     */
    public function indexOf(Element $child)
    {
        return array_search($child, $this->children, true);
    }

    /**
     * Returns the current element.
     *
     * @see Iterator
     *
     * @return null|Element
     */
    public function current()
    {
        return current($this->children);
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
        return key($this->children);
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
        return next($this->children);
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
        return reset($this->children);
    }

    /**
     * Checks if current position is valid.
     *
     * @see Iterator
     *
     * return boolean
     */
    public function valid()
    {
        return key($this->children) !== null;
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
        return isset($this->children[$offset]);
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
        return isset($this->children[$offset]) ? $this->children[$offset] : null;
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
        if (!($value instanceof Element)) {
            throw new \InvalidArgumentException('This value must be an instance of FormManager\\Element');
        }

        $value->setParent($this);
        $this->children[$offset] = $value;
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
        if (isset($this->children[$offset])) {
            $this->children[$offset]->setParent(null);
            unset($this->children[$offset]);
        }
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
        return count($this->children);
    }

    /**
     * Adds new children to this element.
     *
     * @param array $children
     *
     * @return $this;
     */
    public function add(array $children)
    {
        foreach ($children as $offset => $child) {
            $this->offsetSet($offset, $child);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml($prepend = '', $append = '')
    {
        foreach ($this->children as $child) {
            $prepend .= (string) $child;
        }

        return parent::toHtml($prepend, $append);
    }
}
