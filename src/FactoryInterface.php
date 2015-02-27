<?php
namespace FormManager;

/**
 * Interface used by all factories.
 */
interface FactoryInterface
{
    /**
     * Get an instance of an ElementDataInterface.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return null|ElementDataInterface
     */
    public function get($name, array $arguments);
}
