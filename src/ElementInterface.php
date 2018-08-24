<?php

namespace FormManager;

/**
 * Interface used by all html elements.
 */
interface ElementInterface
{
    /**
     * Magic method to convert to html.
     */
    public function __toString();

    /**
     * Set/Get an attribute value.
     *
     * @param mixed $name  If it's null, returns an array with all attributes
     * @param mixed $value null to getter, string to setter
     *
     * @return mixed
     */
    public function attr($name = null, $value = null);

    /**
     * Removes an attribute.
     *
     * @param string $name The attribute name
     *
     * @return self
     */
    public function removeAttribute($name);

    /**
     * Returns or generate an id for this element.
     *
     * @param string $id The new id
     *
     * @return string
     */
    public function id($id = null);

    /**
     * Set the element parent.
     *
     * @param null|ElementInterface $parent
     *
     * @return self
     */
    public function setParent(ElementInterface $parent = null);

    /**
     * Returns the element parent.
     *
     * @return null|ElementInterface
     */
    public function getParent();

    /**
     * Returns the form element.
     *
     * @return null|Fields\Form
     */
    public function getForm();
}
