<?php
namespace FormManager;

/**
 * Interface used by all html elements.
 */
interface ElementInterface extends TreeInterface
{
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
     * @return $this
     */
    public function removeAttr($name);
}
