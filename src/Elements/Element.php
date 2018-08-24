<?php
declare(strict_types = 1);

namespace FormManager\Elements;

use FormManager\ElementInterface;
use FormManager\Fields\Form;

/**
 * Class to manage an html element.
 */
class Element implements ElementInterface
{
    public static $id_prefix = 'fm-';
    public static $id_counter = 0;

    protected $parent;
    protected $name;
    protected $close;
    protected $attributes = [];
    protected $data = [];
    protected $vars = [];
    protected $html;

    /**
     * Escapes a property value.
     */
    protected static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Creates a html attribute.
     *
     * @param mixed  $value
     */
    protected static function getHtmlAttribute(string $name, $value): string
    {
        if (($value === null) || ($value === false)) {
            return '';
        }

        if ($value === true) {
            return " {$name}";
        }

        if (is_array($value)) {
            $value = implode(' ', $value);
        }

        return " {$name}=\"".static::escape($value).'"';
    }

    /**
     * Magic method to convert methods in attributes
     * Ex: ->id('my-id') converts to ->attr('id', 'my-id').
     */
    public function __call(string $name, array $arguments): self
    {
        $this->attr($name, (array_key_exists(0, $arguments) ? $arguments[0] : true));

        return $this;
    }

    public function __debugInfo(): array
    {
        return [
            'attributes' => $this->attributes,
            'data' => $this->data,
            'vars' => $this->vars,
            'html' => $this->html,
        ];
    }

    /**
     * @see ElementInterface
     *
     * {@inheritdoc}
     */
    public function __toString()
    {
        try {
            $string = $this->toHtml();
        } catch (\Exception $exception) {
            return '<pre>'.(string) $exception.'</pre>';
        }

        return $string;
    }

    /**
     * Magic method to clone the elements.
     */
    public function __clone()
    {
        $this->removeAttribute('id');
    }

    /**
     * Changes the name of the element.
     *
     * @param string $name  The element name
     * @param bool   $close True if the element must be closed
     */
    public function setElementName($name, $close)
    {
        $this->name = $name;
        $this->close = $close;
    }

    /**
     * Returns the name of the element.
     *
     * @return string
     */
    public function getElementName()
    {
        return $this->name;
    }

    /**
     * @see ElementInterface
     *
     * {@inheritdoc}
     */
    public function setParent(ElementInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @see ElementInterface
     *
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set/Get the html content for this element.
     *
     * @param null|string $html null to getter, string to setter
     *
     * @return mixed
     */
    public function html($html = null)
    {
        if ($html === null) {
            return $this->html;
        }

        $this->html = $html;

        return $this;
    }

    /**
     * @see ElementInterface
     *
     * {@inheritdoc}
     */
    public function attr($name = null, $value = null)
    {
        if ($name === null) {
            return $this->attributes;
        }

        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->attr($k, $v);
            }

            return $this;
        }

        if ($value === null) {
            $value = isset($this->attributes[$name]) ? $this->attributes[$name] : null;

            return is_array($value) ? implode(' ', $value) : $value;
        }

        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @see ElementInterface
     *
     * {@inheritdoc}
     */
    public function removeAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);

            $class = 'FormManager\\Attributes\\'.ucfirst($name);

            if (class_exists($class) && method_exists($class, 'onRemove')) {
                $class::onRemove($this);
            }
        }

        return $this;
    }

    /**
     * @see ElementInterface
     *
     * {@inheritdoc}
     */
    public function id($id = null)
    {
        if ($id !== null) {
            return $this->attr('id', $id);
        }

        if (!$this->attr('id')) {
            $this->attr('id', static::$id_prefix.(++static::$id_counter));
        }

        return $this->attr('id');
    }

    /**
     * Set/Get data attributes (data-*) to the element.
     *
     * @param null|string $name  The data name. If is null, returns an array with all data
     * @param null|string $value The data value. null to getter, string to setter
     *
     * @return mixed
     */
    public function data($name = null, $value = null)
    {
        if ($name === null) {
            return $this->data;
        }

        if (is_array($name)) {
            foreach ($name as $n => $v) {
                $this->data[$n] = $v;
            }

            return $this;
        }

        if ($value === null) {
            return isset($this->data[$name]) ? $this->data[$name] : null;
        }

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * Removes one data attribute.
     *
     * @param string $name The data name
     *
     * @return self
     */
    public function removeData($name = null)
    {
        if ($name === null) {
            $this->data = [];
        } else {
            unset($this->data[$name]);
        }

        return $this;
    }

    /**
     * Checks whether the element has a specific class or not.
     *
     * @param string $class The class name to check
     *
     * @return bool
     */
    public function hasClass($class)
    {
        $classes = $this->attr('class');

        if (!$classes) {
            return false;
        }

        if (!is_array($classes)) {
            $classes = explode(' ', $classes);
        }

        return in_array($class, $classes);
    }

    /**
     * Add one or more classes to the element.
     *
     * @param array|string $class The class or classes names.
     *
     * @return self
     */
    public function addClass($class)
    {
        $classes = $this->attr('class');

        if (!$classes) {
            return $this->attr('class', $class);
        }

        if (!is_array($classes)) {
            $classes = explode(' ', $classes);
        }

        if (!is_array($class)) {
            $class = explode(' ', $class);
        }

        return $this->attr('class', array_unique(array_merge($classes, $class)));
    }

    /**
     * Removes one or more classes.
     *
     * @param array|string $class The class or classes names
     *
     * @return self
     */
    public function removeClass($class)
    {
        $classes = $this->attr('class');

        if (!$classes) {
            return $this;
        }

        if (!is_array($classes)) {
            $classes = explode(' ', $classes);
        }

        if (!is_array($class)) {
            $class = explode(' ', $class);
        }

        return $this->attr('class', array_diff($classes, $class));
    }

    /**
     * Returns the attributes as string.
     *
     * @return string
     */
    protected function attrToHtml()
    {
        $html = '';

        foreach ($this->attributes as $name => $value) {
            $html .= static::getHtmlAttribute($name, $value);
        }

        foreach ($this->data as $name => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }

            $html .= static::getHtmlAttribute("data-{$name}", $value);
        }

        return $html;
    }

    /**
     * Set variables.
     *
     * @param string|array $name
     * @param mixed        $value
     *
     * @return self
     */
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            $this->vars = array_replace($this->vars, $name);

            return $this;
        }

        $this->vars[$name] = $value;

        return $this;
    }

    /**
     * Get variables.
     *
     * @param null|string $name If it's null, returns an array with all variables
     *
     * @return mixed
     */
    public function get($name = null)
    {
        if ($name === null) {
            return $this->vars;
        }

        return isset($this->vars[$name]) ? $this->vars[$name] : null;
    }

    /**
     * Returns the form element.
     *
     * @return null|Form
     */
    public function getForm()
    {
        if ($this->parent) {
            return ($this->parent instanceof Form) ? $this->parent : $this->parent->getForm();
        }
    }

    /**
     * Return the element as html string.
     *
     * @param string $prepend Optional string prepended to html content
     * @param string $append  Optional string appended to html content
     *
     * @return string
     */
    public function toHtml($prepend = '', $append = '')
    {
        $html = $this->openHtml();

        if ($this->close) {
            $html .= $prepend.$this->html().$append.$this->closeHtml();
        }

        return $html;
    }

    /**
     * Returns the open element tag.
     *
     * @return string
     */
    public function openHtml()
    {
        return '<'.$this->name.$this->attrToHtml().'>';
    }

    /**
     * Returns the close element tag.
     *
     * @return string
     */
    public function closeHtml()
    {
        return ($this->close) ? '</'.$this->name.'>' : '';
    }
}
