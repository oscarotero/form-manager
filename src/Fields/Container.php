<?php

namespace FormManager\Fields;

use FormManager\Traits\ValidateTrait;
use FormManager\Traits\RenderTrait;
use FormManager\Traits\StructureTrait;
use FormManager\FieldInterface;
use FormManager\Elements\Div;

abstract class Container extends Div implements FieldInterface
{
    use RenderTrait;
    use StructureTrait;
    use ValidateTrait {
        validate as private validateThis;
    }

    public function __construct(array $children = null)
    {
        if ($children) {
            $this->add($children);
        }
    }

    /**
     * Loads a value sent by the client.
     *
     * @param mixed $value The GET/POST/FILES value
     *
     * @return self
     */
    public function load($value = null)
    {
        if ($this->sanitizer) {
            $value = call_user_func($this->sanitizer, $value);
        }

        foreach ($this->children as $key => $child) {
            $child->load(isset($value[$key]) ? $value[$key] : null);
        }

        return $this;
    }

    /**
     * Set/Get values of this container.
     *
     * @param null|array $value null to getter, array to setter
     *
     * @return mixed
     */
    public function val($value = null)
    {
        if ($value === null) {
            $values = [];

            foreach ($this->children as $key => $child) {
                $values[$key] = $child->val();
            }

            return $values;
        }

        foreach ($this->children as $key => $child) {
            $child->val(isset($value[$key]) ? $value[$key] : null);
        }

        return $this;
    }

    /**
     * Returns all childrens contaning errors.
     *
     * @return array
     */
    public function getElementsWithErrors()
    {
        $elements = [];

        if (strlen($this->error())) {
            $elements[] = $this;
        }

        foreach ($this->children as $child) {
            if ($child instanceof self) {
                foreach ($child->getElementsWithErrors() as $element) {
                    $elements[] = $element;
                }
            } elseif (strlen($child->error())) {
                $elements[] = $child;
            }
        }

        return $elements;
    }

    /**
     * {@inheritdoc}
     *
     * @see ElementContainer::toHtml
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        return parent::toHtml($prepend, $append);
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function validate()
    {
        $result = $this->validateThis();

        foreach ($this->children as $child) {
            if ($child->validate() === false) {
                $result = false;
            }
        }

        return $result;
    }
}
