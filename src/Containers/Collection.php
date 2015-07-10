<?php
namespace FormManager\Containers;

use FormManager\DataElementInterface;
use FormManager\Builder as F;

class Collection extends Group
{
    public $template;

    protected $parentPath;

    public function __construct(array $children = null)
    {
        $this->template = F::group();

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

        $this->valid = null;

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
    public function load($value = null)
    {
        $this->children = [];
        $this->valid = null;

        if ($value) {
            foreach ($value as $k => $v) {
                $this->pushLoad($v);
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
        $this->valid = null;

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
     * @param mixed $template The new template
     *
     * @return $this
     */
    public function setTemplate($template)
    {
        if (is_array($template)) {
            $template = F::group($template);
        } elseif (!($template instanceof Group)) {
            throw new \InvalidArgumentException('Invalid type of the template. Only arrays and FormManager\\Containers\\Group are allowed');
        }

        $this->template = $template;

        return $this;
    }

    /**
     * Returns the template used to create all values.
     *
     * @param mixed $index The index used to generate the input name
     *
     * @return DataElementInterface The cloned field
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
     * @param mixed $value The GET/POST/FILES value
     *
     * @return Group The child inserted
     */
    public function pushLoad($value = null)
    {
        $child = clone $this->template;

        if ($value) {
            if ($this->sanitizer) {
                $value = call_user_func($this->sanitizer, $value);
            }

            $child->load($value);
        }

        return $this[] = $child;
    }
}
