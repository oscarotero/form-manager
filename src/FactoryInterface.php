<?php
namespace FormManager;

/**
 * Interface used by all factories
 */
interface FactoryInterface
{
    /**
     * Get an instance of an FormElementInterface
     *
     * @param string $name
     * @param array  $arguments
     * 
     * @return null|FormElementInterface
     */
    public function get($name, array $arguments);
}
