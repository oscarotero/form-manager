<?php

namespace FormManager;

/**
 * Interface used by all elements to keep the basic tree behaviour.
 */
interface TreeInterface
{
    /**
     * Magic method to convert to html.
     */
    public function __toString();

    /**
     * Set the element parent.
     *
     * @param null|ElementInterface $parent
     *
     * @return self
     */
    public function setParent(TreeInterface $parent = null);

    /**
     * Returns the element parent.
     *
     * @return null|ElementInterface
     */
    public function getParent();

    /**
     * Returns the form element.
     *
     * @return null|Containers\Form
     */
    public function getForm();
}
