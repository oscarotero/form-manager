<?php
namespace FormManager;

class Element
{
    protected $name;
    protected $close;
    protected $attributes = [];
    protected $data = [];
    protected $html;

    /**
     * Magic method to create new instances using the API Element::div(bool $close)
     *
     * @return Element
     */
    public static function __callStatic($name, $arguments)
    {
        $element = new Element();

        $element->setElementName($name, !empty($arguments[0]));

        return $element;
    }

    /**
     * Escapes a property value
     *
     * @param string $value
     *
     * @return string
     */
    protected static function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Magic method to convert methods in attributes
     * Ex: ->id('my-id') converts to ->attr('id', 'my-id')
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return self
     */
    public function __call($name, $arguments)
    {
        $this->attr($name, (array_key_exists(0, $arguments) ? $arguments[0] : true));

        return $this;
    }

    /**
     * Magic method to convert to html
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * Changes the name of the element
     *
     * @param string  $name  The element name
     * @param boolean $close True if the element must be closed
     */
    public function setElementName($name, $close)
    {
        $this->name = $name;
        $this->close = $close;
    }

    /**
     * Returns the name of the element
     *
     * @return string
     */
    public function getElementName()
    {
        return $this->name;
    }

    /**
     * Set/Get the html content for this element
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
     * Set/Get an attribute value
     *
     * @param null|string|array $name  If it's null, returns an array with all attributes
     * @param null|string|array $value null to getter, string to setter
     *
     * @return mixed
     */
    public function attr($name = null, $value = null)
    {
        if ($name === null) {
            return $this->attributes;
        }

        if (is_array($name)) {
            foreach ($name as $name => $value) {
                $this->attr($name, $value);
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
     * Removes an attribute
     *
     * @param string $name The attribute name
     *
     * @return self
     */
    public function removeAttr($name)
    {
        unset($this->attributes[$name]);

        return $this;
    }

    /**
     * Set/Get data attributes (data-*) to the element
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
            foreach ($name as $name => $value) {
                $this->data[$name] = $value;
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
     * Removes one data attribute
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
     * Checks whether the element has a specific class or not
     *
     * @param string $class The class name to check
     *
     * @return boolean
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
     * Add one or more classes to the element
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
     * Removes one or more classes
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
     * Returns the attributes as string
     *
     * @return string
     */
    protected function attrToHtml()
    {
        $html = '';

        foreach ($this->attributes as $name => $value) {
            if (($value === null) || ($value === false)) {
                continue;
            }

            if ($value === true) {
                $html .= " $name";
            } else {
                if (is_array($value)) {
                    $value = implode(' ', $value);
                }

                $html .= " $name=\"".static::escape($value)."\"";
            }
        }

        foreach ($this->data as $name => $value) {
            $html .= " data-$name=\"".static::escape($value)."\"";
        }

        return $html;
    }

    /**
     * Return the element as html string
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
     * Returns the open element tag
     *
     * @return string
     */
    public function openHtml()
    {
        return '<'.$this->name.$this->attrToHtml().'>';
    }

    /**
     * Returns the close element tag
     *
     * @return string
     */
    public function closeHtml()
    {
        return ($this->close) ? '</'.$this->name.'>' : '';
    }
}
