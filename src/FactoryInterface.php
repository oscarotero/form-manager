<?php
namespace FormManager;

/**
 * Interface used by all factories.
 */
interface FactoryInterface
{
    /**
     * Get an instance of an DataElementInterface.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function get($name, array $arguments);
}
