<?php
namespace FormManager\Fields;

use FormManager\FormElementInterface;
use FormManager\FormContainerInterface;

class CollectionMultiple extends Group implements FormElementInterface, FormContainerInterface
{
    public $keyField;
    public $fields = [];

    protected $index = 0;
    protected $parentPath;

    public function __construct(array $fields = null, $keyField = 'type')
    {
        if ($fields) {
            foreach ($fields as $key => $field) {
                if ($field instanceof FormElementInterface) {
                    $this->fields[$key] = $field;
                } else {
                    $this->fields[$key] = new Group($field);
                }
            }
        }

        $this->keyField = $keyField;
    }

    /**
     * {@inheritDoc}
     */
    public function add($key, FormElementInterface $value = null)
    {
        $this->fields[$key] = $value;

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
                if (isset($value[$this->keyField])) {
                    $this->createChild($value[$this->keyField], $key)->load($value, isset($file[$key]) ? $file[$key] : null);
                }
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
                if (isset($value[$this->keyField])) {
                    $this->createChild($value[$this->keyField], $key)->val($value);
                }
            }
        }

        return $this;
    }

    /**
     * Create and insert new children.
     *
     * @param string       $type  The child type
     * @param null|integer $index The index of the child. Null to autogenerate
     *
     * @return FormElementInterface The new added child
     */
    protected function createChild($type, $index = null)
    {
        if (!isset($this->fields[$type])) {
            return false;
        }

        if ($index === null) {
            $index = $this->index++;
        }

        $child = $this->children[$index] = clone $this->fields[$type];

        $child->setParent($this);
        $this->prepareChild($child, $index, $this->parentPath);

        return $child;
    }

    /**
     * Returns a child without insert into.
     *
     * @param string $type The child type
     *
     * @return FormElementInterface The cloned field
     */
    public function getTemplateChild($type, $index = '::n::')
    {
        $child = clone $this->fields[$type];

        $child->setParent($this);
        $this->prepareChild($child, $index, $this->parentPath);

        return $child;
    }

    /**
     * Adds new empty child values.
     *
     * @param string       $type  The child type
     * @param null|integer $index The index of the child. Null to autogenerate
     *
     * @return FormElementInterface The new added child
     */
    public function addChild($type, $index = null)
    {
        $this->createChild($type, $index);

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
