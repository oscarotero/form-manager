<?php
namespace FormManager\Elements;

use FormManager\TreeInterface;
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
     * @param TreeInterface $child
     *
     * @return mixed
     */
    public function indexOf(TreeInterface $child)
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
        if (!($value instanceof TreeInterface)) {
            throw new \InvalidArgumentException('This value must be an instance of FormManager\\TreeInterface');
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
        if (empty($this->children[$offset])) {
            return;
        }

        $this->children[$offset]->setParent(null);
        unset($this->children[$offset]);
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
     * Get the html content for this element.
     *
     * @throws \InvalidArgumentException On set html content.
     *
     * @return string
     */
    public function html($html = null)
    {
        if ($html !== null) {
            throw new \InvalidArgumentException("Element containers cannot store html");
        }

        $html = '';

        foreach ($this->children as $child) {
            $html .= (string) $child;
        }

        return $html;
    }

    /**
     * Adds new children to this element.
     *
     * @param array $children
     *
     * @return $this
     */
    public function add(array $children)
    {
        foreach ($children as $offset => $child) {
            $this->offsetSet($offset, $child);
        }

        return $this;
    }

    /**
     * Removes all children
     *
     * @return $this
     */
    public function clear()
    {
        $this->children = [];

        return $this;
    }
}
