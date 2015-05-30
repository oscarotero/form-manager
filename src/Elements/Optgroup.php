<?php
namespace FormManager\Elements;

use FormManager\TreeInterface;

/**
 * Class to manage an optgroup of a select.
 */
class Optgroup extends ElementContainer
{
    protected $name = 'optgroup';
    protected $close = true;
    protected $select;

    /**
     * Optgroup constructor.
     *
     * @param null|array  $attributes Html attributes of this optgroup
     * @param array       $options    Options contained by this optgroup
     */
    public function __construct(array $attributes = null, array $options = null)
    {
        if ($attributes !== null) {
            $this->attr($attributes);
        }

        if ($options !== null) {
            foreach ($options as $offset => $option) {
                $this->offsetSet($offset, $option);
            }
        }
    }

    /**
     * @see TreeInterface
     *
     * {@inheritdoc}
     */
    public function setParent(TreeInterface $parent = null)
    {
        if (!($parent instanceof Select)) {
            throw new \Exception("Optgroups only can belong to Select instances");
        }

        $this->parent = $parent;

        //Add the options to the select
        foreach ($this->children as $offset => $value) {
            $parent->offsetSet($offset, $value);

            //Keep the parent to this
            $value->setParent($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof Option) {
            $value->attr('value', $offset);
        } else {
            $value = Option::create($offset, $value);
        }

        //Add option to select
        if ($this->parent) {
            $this->parent->offsetSet($offset, $value);
        }

        //Add option to optgroup
        parent::offsetSet($offset, $value);
    }
}
