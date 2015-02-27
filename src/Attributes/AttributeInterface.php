<?php
namespace FormManager\Attributes;

use FormManager\DataElementInterface;

/**
 * Interface used by all attribute classes.
 */
interface AttributeInterface
{
    /**
     * Callback used on add this attribute to an input.
     *
     * @param DataElementInterface $input The input in which the attribute will be added
     * @param mixed                $value The value of this attribute
     *
     * @throws \InvalidArgumentException If the value is not the correct mimetype
     *
     * @return mixed $value The value sanitized
     */
    public static function onAdd(DataElementInterface $input, $value);

    /**
     * Callback used on remove this attribute from an input.
     *
     * @param DataElementInterface $input The input from the attribute will be removed
     */
    public static function onRemove(DataElementInterface $input);
}
