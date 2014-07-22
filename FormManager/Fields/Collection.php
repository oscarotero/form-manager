<?php
namespace FormManager\Fields;

use FormManager\Traits\ChildTrait;
use FormManager\Traits\CollectionTrait;

use FormManager\Label;
use FormManager\CollectionInterface;

use Iterator;
use ArrayAccess;

class Collection implements Iterator, ArrayAccess, CollectionInterface
{
    protected $render;

    use ChildTrait, CollectionTrait {
        CollectionTrait::__clone as private __collectionClone;
    }

    public function __construct(array $children = null)
    {
        if ($children) {
            $this->add($children);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    public function __clone()
    {
        $this->__collectionClone();

        if (isset($this->label)) {
            $this->label = clone $this->label;
        }
    }

    public function __get($name)
    {
        if ($name === 'label') {
            return $this->label = new Label();
        }

        if (($name === 'errorLabel') && ($error = $this->error())) {
            return new Label(null, ['class' => 'error'], $error);
        }
    }

    /**
     * Creates/edit/returns the label associated with the input
     *
     * @param null|string $html Null to get the label html, string to create/edit the label content
     *
     * @return $this
     */
    public function label($html = null)
    {
        if ($html === null) {
            return $this->label->html();
        }

        $this->label->html($html);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function render(callable $render)
    {
        $this->render = $render;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function error($error = null)
    {
        if ($error === null) {
            return $this->error;
        }

        $this->error = $error;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function id($id = null)
    {
        if ($id === null) {
            if (empty($this->attributes['id'])) {
                $this->attributes['id'] = uniqid('id_', true);
            }

            return $this->attributes['id'];
        }

        $this->attributes['id'] = $id;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toHtml()
    {
        $label = isset($this->label) ? $this->label : null;

        if ($this->render) {
            $render = $this->render;

            return $render($this->children, $label, $this->errorLabel);
        }

        $html = $this->childrenToHtml();

        return "{$label} {$html} {$this->errorLabel}";
    }
}
