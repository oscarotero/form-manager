<?php
namespace FormManager;

/**
 * Interface used by all elements with children
 */
interface FormContainerInterface
{
    /**
     * Prepare a child element before insert
     *
     * @param InputInferface $child
     * @param string         $key        The key used to append this child (the input name)
     * @param null|string    $parentPath The full parent path (the parents names)
     * @return void
     */
    public function prepareChild($child, $key, $parentPath = null);

    /**
     * Prepare the children before insert
     *
     * @param null|string $parentPath The full parent path (the parents names)
     * @return void
     */
    public function prepareChildren($parentPath = null);
}
