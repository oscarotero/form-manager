<?php
namespace FormManager\Fields;

use FormManager\Element;
use FormManager\FormElementInterface;
use FormManager\FormContainerInterface;

class Collection extends Group implements FormElementInterface, FormContainerInterface
{
    public $field;

    protected $index = 0;
    protected $parentPath;

    public function __construct($children = null)
    {
        if ($children instanceof FormElementInterface) {
            $this->field = $children;
        } else {
            $this->field = new Group($children);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function add($key, FormElementInterface $value = null)
    {
        $this->field->add($key, $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        if (($sanitizer = $this->sanitizer) !== null) {
            $value = $sanitizer($value);
        }

        $this->children = [];
        $this->index = 0;

        if ($value) {
            foreach ($value as $key => $value) {
                $child = isset($this->children[$key]) ? $this->children[$key] : $this->createChild($key);

                $child->load($value, isset($file[$key]) ? $file[$key] : null);
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
            foreach ($value as $key => $value) {
                $child = isset($this->children[$key]) ? $this->children[$key] : $this->createChild($key);

                $child->val($value);
            }
        }

        return $this;
    }

    /**
     * Create and insert new children
     *
     * @param null|integer $index The index of the child. Null to autogenerate
     *
     * @return FormElementInterface The new added child
     */
    protected function createChild($index = null)
    {
        if ($index === null) {
            $index = $this->index++;
        }

        $child = $this->children[$index] = clone $this->field;

        $child->setParent($this);
        $this->prepareChild($child, $index, $this->parentPath);

        return $child;
    }

    /**
     * Returns a child without insert into
     *
     * @return FormElementInterface The cloned field
     */
    public function getTemplateChild($index = '::n::')
    {
        $child = clone $this->field;

        $child->setParent($this);
        $this->prepareChild($child, $index, $this->parentPath);

        return $child;
    }

    /**
     * Adds new empty child values
     *
     * @param null|integer $index The index of the child. Null to autogenerate
     *
     * @return FormElementInterface The new added child
     */
    public function addChild($index = null)
    {
        $this->createChild($index);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function prepareChildren($parentPath = null)
    {
        $this->parentPath = $parentPath;

        foreach ($this->children as $key => $child) {
            $this->prepareChild($child, $key, $this->parentPath);
        }
    }
}
