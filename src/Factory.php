<?php

namespace FormManager;

use InvalidArgumentException;

/**
 * Factory class to create all nodes.
 */
class Factory
{
    const INPUTS_NAMESPACE = 'FormManager\\Inputs\\';
    const GROUPS_NAMESPACE = 'FormManager\\Groups\\';

    /**
     * Factory to create input nodes
     */
    public static function __callStatic(string $name, $arguments)
    {
        if ($name === 'form') {
            return new Form(...$arguments);
        }

        $class = self::INPUTS_NAMESPACE.ucfirst($name);

        if (class_exists($class)) {
            return new $class(...$arguments);
        }

        $class = self::GROUPS_NAMESPACE.ucfirst($name);

        if (class_exists($class)) {
            return new $class(...$arguments);
        }

        throw new InvalidArgumentException(
            sprintf('Input %s not found', $name)
        );
        
    }
}
