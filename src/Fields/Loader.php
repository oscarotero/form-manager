<?php

namespace FormManager\Fields;

class Loader extends Group
{
    /**
     * {@inheritdoc}
     */
    public function add(array $children)
    {
        $allowed = ['loader' => null, 'field' => null];

        if (array_diff_key($children, $allowed)) {
            throw new \InvalidArgumentException("Only 'loader' and 'field' keys are available.");
        }

        return parent::add($children);
    }

    /**
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this['loader']->val() ?: $this['field']->val();
        }

        $this['field']->val($value);

        return $this;
    }
}
