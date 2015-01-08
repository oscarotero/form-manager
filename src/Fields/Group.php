<?php
namespace FormManager\Fields;

use FormManager\Traits\ChildTrait;
use FormManager\Traits\ParentTrait;
use FormManager\Traits\ValidationTrait;
use FormManager\Label;
use FormManager\FormElementInterface;
use FormManager\FormContainerInterface;
use FormManager\Traits\VarsTrait;
use Iterator;
use ArrayAccess;

/**
 * @property null|Label $label
 * @property null|Label $errorLabel
 */
class Group implements Iterator, ArrayAccess, FormElementInterface, FormContainerInterface
{
    protected $render;
    protected $rendering = false;

    use ChildTrait, ValidationTrait, VarsTrait, ParentTrait {
        ParentTrait::__clone as private __collectionClone;
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
     * @return self
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
        if ($this->render && !$this->rendering) {
            $this->rendering = true;
            $html = call_user_func($this->render, $this);
            $this->rendering = false;

            return $html;
        }

        $label = isset($this->label) ? $this->label : null;
        $html = $this->childrenToHtml();

        return "{$label} {$html} {$this->errorLabel}";
    }
}
