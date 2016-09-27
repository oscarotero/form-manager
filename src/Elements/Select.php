<?php

namespace FormManager\Elements;

use FormManager\Traits\ValidateTrait;
use FormManager\Traits\StructureTrait;
use FormManager\Traits\LabelTrait;
use FormManager\InputInterface;

class Select extends ElementContainer implements InputInterface
{
    use ValidateTrait;
    use StructureTrait;
    use LabelTrait;

    protected $name = 'select';
    protected $value;
    protected $allowNewValues = false;
    protected $optgroups = [];

    public function __construct()
    {
        $this->addValidator('FormManager\\Validators\\Select::validate');
    }

    /**
     * {@inheritdoc}
     */
    public function attr($name = null, $value = null)
    {
        if (is_string($name)) {
            if ($value === null) {
                if ($name === 'name' && $this->getParent()) {
                    return $this->getNameAttr();
                }

                return parent::attr($name);
            }

            if ($name === 'name' && $this->getParent()) {
                throw new \InvalidArgumentException('The attribute "name" is read only!');
            }

            $value = $this->attrToValidator($name, $value);
        }

        return parent::attr($name, $value);
    }

    /**
     * Generate the right name attribute for this input.
     *
     * @return string
     */
    private function getNameAttr()
    {
        $name = $this->getPath();

        if ($this->attr('multiple')) {
            $name .= '[]';
        }

        return $name;
    }

    public function offsetSet($offset, $value)
    {
        if ($value instanceof Option) {
            $value->attr('value', $offset);
        } else {
            $value = Option::create($offset, $value);
        }

        parent::offsetSet($offset, $value);
    }

    /**
     * Set/Get the available options in this select.
     *
     * @param null|array $options null to getter, array to setter
     *
     * @return mixed
     */
    public function options(array $options = null)
    {
        if ($options === null) {
            return $this->children;
        }

        foreach ($options as $offset => $option) {
            $this->offsetSet($offset, $option);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function load($value = null)
    {
        if ($this->sanitizer === null) {
            $this->val($value === null ? '' : $value);

            return $this;
        }

        if ($this->attr('multiple') && is_array($value)) {
            foreach ($value as &$val) {
                $val = call_user_func($this->sanitizer, $val);
            }
        } else {
            $value = call_user_func($this->sanitizer, $value);
        }

        $this->val($value === null ? '' : $value);

        return $this;
    }

    /**
     * Set/Get the available optgroup in this select.
     *
     * @param null|array $optgroups null to getter, array to setter
     *
     * @return mixed
     */
    public function optgroups(array $optgroups = null)
    {
        if ($optgroups === null) {
            return $this->optgroups;
        }

        foreach ($optgroups as $name => $optgroup) {
            if (!($optgroup instanceof Optgroup)) {
                $optgroup = (new Optgroup())
                    ->attr('label', $name)
                    ->add($optgroup);
            }

            $this->optgroups[$name] = $optgroup->setParent($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->optgroups = [];

        return parent::clear();
    }

    /**
     * {@inheritdoc}
     */
    public function html($html = null)
    {
        if ($html !== null) {
            parent::html($html);
        }

        $html = '';

        //render the options not belonging to optgroups
        foreach ($this->children as $option) {
            if ($option->getParent() === $this) {
                $html .= (string) $option;
            }
        }

        //render the optgroups
        if (!empty($this->optgroups)) {
            foreach ($this->optgroups as $optgroup) {
                $html .= (string) $optgroup;
            }
        }

        return $html;
    }

    /**
     * Set true to allow values non defined in the $options array
     * Useful to insert dinamically new values.
     *
     * @param bool $allow
     *
     * @return self
     */
    public function allowNewValues($allow = true)
    {
        $this->allowNewValues = $allow;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->value;
        }

        if ($this->attr('multiple') && !is_array($value)) {
            if (strlen($value) || isset($this->children[$value])) {
                $value = [$value];
            } else {
                $value = [];
            }
        }

        if (is_array($value)) {
            $this->value = $this->applyValues($value);
        } else {
            $value = $this->applyValues((array) $value);
            $this->value = $value[0];
        }

        return $this;
    }

    private function applyValues(array $value)
    {
        //Uncheck all
        foreach ($this->children as $option) {
            $option->uncheck();
        }

        //Normalize values
        $value = array_keys(array_flip($value));

        //check the selected values
        foreach ($value as $val) {
            if (!isset($this->children[$val])) {
                if (!$this->allowNewValues) {
                    continue;
                }

                $this[$val] = $val;
            }

            $this->children[$val]->check();
        }

        return $value;
    }

    /**
     * Calculate the input name on print.
     *
     * {@inheritdoc}
     */
    protected function attrToHtml()
    {
        //Generate the name
        if (($name = $this->getPath()) !== null) {
            $this->attributes['name'] = $this->getNameAttr();
        }

        //Generate the aria attributes for labels http://www.html5accessibility.com/tests/mulitple-labels.html
        $labelled = [];

        foreach ($this->labels as $label) {
            if ($label->html()) {
                $labelled[] = $label->id();
            }
        }

        if (count($labelled)) {
            $this->attributes['aria-labelledby'] = $labelled;
        }

        //Generate the datalist attribute
        if (!empty($this->datalist) && $this->datalist->count() > 0) {
            $this->attributes['list'] = $this->datalist->id();
        }

        return parent::attrToHtml();
    }
}
