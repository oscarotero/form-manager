<?php
/**
 * Trait with common method for elements having children (form, collection, etc)
 */
namespace FormManager\Traits;

use FormManager\FormElementInterface;
use FormManager\FormContainerInterface;

trait ParentTrait
{
    protected $children = [];
    protected $sanitizer;

    public function __clone()
    {
        foreach ($this->children as $key => $child) {
            $this->children[$key] = clone $child;
            $this->children[$key]->setParent($this);
        }
    }

    //Iterator interface methods:
    public function rewind()
    {
        return reset($this->children);
    }

    public function current()
    {
        return current($this->children);
    }

    public function key()
    {
        return key($this->children);
    }

    public function next()
    {
        return next($this->children);
    }

    public function valid()
    {
        return key($this->children) !== null;
    }

    //ArrayAccess interface methods
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            throw new \InvalidArgumentException('You must define a key to every element added');
        }

        $this->add($offset, $value);
    }

    public function offsetExists($offset)
    {
        return isset($this->children[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->children[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->children[$offset]) ? $this->children[$offset] : null;
    }

    /**
     * Adds new children to this element
     *
     * @param array|string         $key   The child name or an array with children
     * @param FormElementInterface $value The child
     *
     * @return self;
     */
    public function add($key, FormElementInterface $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $key => $value) {
                $this->add($key, $value);
            }

            return $this;
        }

        $this->children[$key] = $value->setParent($this);
        $this->prepareChild($value, $key);

        return $this;
    }

    /**
     * Checks whether all input values are valid
     *
     * @return boolean
     */
    public function isValid()
    {
        $valid = true;

        foreach ($this->children as $child) {
            if (!$child->isValid()) {
                $valid = false;
            }
        }

        if (!$this->validate()) {
            $valid = false;
        }

        return $valid;
    }

    /**
     * Set/Get the values of this collection
     *
     * @param null|array $value null to getter, array to setter
     *
     * @return mixed
     */
    public function val($value = null)
    {
        if ($value === null) {
            $value = [];

            foreach ($this->children as $key => $child) {
                $value[$key] = $child->val();
            }

            return $value;
        }

        foreach ($this->children as $key => $child) {
            $child->val(isset($value[$key]) ? $value[$key] : null);
        }

        return $this;
    }

    /**
     * Loads a value sent by the client
     *
     * @param mixed $value The GET/POST value
     * @param mixed $file  The FILES value (used in input[type="file"])
     *
     * @return self
     */
    public function load($value = null, $file = null)
    {
        if (($sanitizer = $this->sanitizer) !== null) {
            $value = $sanitizer($value);
        }

        foreach ($this->children as $key => $child) {
            $child->load(
                isset($value[$key]) ? $value[$key] : null,
                isset($file[$key]) ? $file[$key] : null
            );
        }

        return $this;
    }

    /**
     * Sets a sanitizer function to the input
     *
     * @param callable $sanitizer The function name or closure
     *
     * @return self
     */
    public function sanitize(callable $sanitizer)
    {
        $this->sanitizer = $sanitizer;

        return $this;
    }

    /**
     * Prepare the children before insert
     *
     * @param null|string $parentPath The full parent path (the parents names)
     */
    public function prepareChildren($parentPath = null)
    {
        foreach ($this->children as $key => $child) {
            $this->prepareChild($child, $key, $parentPath);
        }
    }

    /**
     * Prepare a child element before insert
     *
     * @param InputInferface $child
     * @param string         $key        The key used to append this child (the input name)
     * @param null|string    $parentPath The full parent path (the parents names)
     */
    public function prepareChild($child, $key, $parentPath = null)
    {
        $path = $parentPath ? "{$parentPath}[{$key}]" : $key;

        if ($child instanceof FormContainerInterface) {
            $child->prepareChildren($path);
        } else {
            $child->attr('name', $path);
        }
    }

    /**
     * Returns the html of all childrens
     *
     * @return string
     */
    public function childrenToHtml()
    {
        $html = '';

        foreach ($this->children as $child) {
            $html .= (string) $child;
        }

        return $html;
    }
}
