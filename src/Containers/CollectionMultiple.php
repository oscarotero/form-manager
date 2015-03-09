<?php
namespace FormManager\Containers;

use FormManager\Builder as F;

class CollectionMultiple extends Collection
{
    public $template = [];

    protected $keyField = 'type';

    public function __construct(array $children = null)
    {
        if ($children) {
            $this->add($children);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function add(array $children)
    {
        foreach ($children as $type => $child) {
            $child = F::group($child);

            if (!isset($child[$this->keyField])) {
                $child[$this->keyField] = F::hidden()->val($type);
            }

            $this->template[$type] = $child;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return array All templates. The index are the template type
     */
    public function getTemplate($index = '::n::')
    {
        $templates = [];

        foreach ($this->template as $type => $template) {
            $template = clone $template;

            $templates[$type] = $template->setParent($this)->setKey($index);
        }

        return $templates;
    }

    /**
     * {@inheritdoc}
     */
    public function pushVal($value = null)
    {
        if (!isset($value[$this->keyField])) {
            throw new \Exception("The value {$this->keyField} is required on add new values in CollectionMultiple");
        }

        $type = $value[$this->keyField];
        $child = clone $this->template[$type];

        if ($value) {
            $child->val($value);
        }

        return $this[] = $child;
    }

    /**
     * {@inheritdoc}
     */
    public function pushLoad($value = null)
    {
        if (!isset($value[$this->keyField])) {
            throw new \Exception("The value {$this->keyField} is required on add new values in CollectionMultiple");
        }

        $type = $value[$this->keyField];
        $child = clone $this->template[$type];
        $child->load($value);

        return $this[] = $child;
    }
}
