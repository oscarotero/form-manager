<?php
namespace FormManager\Fields;

use FormManager\Traits\ChildTrait;
use FormManager\Traits\ParentTrait;
use FormManager\Traits\ValidationTrait;

use FormManager\Element;
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
    public $wrapper;

    protected $render;

    use ChildTrait, ValidationTrait, VarsTrait, ParentTrait {
        ParentTrait::__clone as private __collectionClone;
    }

    public function __construct(array $children = null)
    {
        if ($children) {
            $this->add($children);
        }

        $this->wrapper = Element::div(true);
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
            if (empty($this->wrapper->attr('id'))) {
                $this->wrapper->attr('id', uniqid('id_', true));
            }

            return $this->wrapper->attr('id');
        }

        $this->wrapper->attr('id', $id);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function attr($name = null, $value = null)
    {
        if (($value !== null) || (is_array($name))) {
            $this->wrapper->attr($name, $value);

            return $this;
        }

        return $this->wrapper->attr($name);
    }

    /**
     * {@inheritDoc}
     */
    public function removeAttr($name)
    {
        $this->wrapper->removeAttr($name);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toHtml()
    {
        if ($this->render) {
            return call_user_func($this->render, $this);
        }

        $label = isset($this->label) ? $this->label : null;
        $html = $this->childrenToHtml();

        return $this->wrapper->toString("{$label} {$html} {$this->errorLabel}");
    }
}
