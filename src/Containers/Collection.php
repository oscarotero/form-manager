<?php
namespace FormManager\Containers;

use FormManager\FormElementInterface;

class Collection extends Group
{
    public $template;

    protected $parentPath;

    public function __construct(array $children = null)
    {
        $this->template = new Group();

        parent::__construct($children);
    }

    /**
     * @see ArrayAccess
     *
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $offset = count($this->children);
        }

        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function add(array $children)
    {
        $this->template->add($children);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        $this->children = [];

        if ($value) {
            foreach ($value as $k => $v) {
                $this->pushLoad($v, isset($file[$k]) ? $file[$k] : null);
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return parent::val();
        }

        $this->children = [];

        if ($value) {
            foreach ($value as $v) {
                $this->pushVal($v);
            }
        }

        return $this;
    }

    /**
     * Returns the template used to create all values.
     *
     * @param mixed $index The index used to generate the input name
     *
     * @return FormElementInterface The cloned field
     */
    public function getTemplate($index = '::n::')
    {
        $template = clone $this->template;

        $template->setParent($this)->setKey($index);

        return $template;
    }

    /**
     * Adds a new value child.
     *
     * @param null|array $value
     *
     * @return Group The child inserted
     */
    public function pushVal($value = null)
    {
        $child = clone $this->template;

        if ($value) {
            $child->val($value);
        }

        return $this[] = $child;
    }

    /**
     * Adds a new value child and load content.
     *
     * @param mixed $value The GET/POST value
     * @param mixed $file  The FILES value (used in input[type="file"])
     *
     * @return Group The child inserted
     */
    public function pushLoad($value = null, $file = null)
    {
        $child = clone $this->template;

        if ($value) {
            if ($this->sanitizer) {
                $value = call_user_func($this->sanitizer, $value);
            }

            $child->load($value, $file);
        }

        return $this[] = $child;
    }
}
