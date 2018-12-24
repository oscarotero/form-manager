<?php

namespace FormManager;

use InvalidArgumentException;

/**
 * Factory class to create all nodes.
 */
class Factory
{
    const NAMESPACES = [
        'FormManager\\Inputs\\',
        'FormManager\\Groups\\',
    ];

    /**
     * Factory to create input nodes
     */
    public static function __callStatic(string $name, $arguments)
    {
        if ($name === 'form') {
            return new Form(...$arguments);
        }

        foreach (self::NAMESPACES as $namespace) {
            $class = $namespace.ucfirst($name);

            if (class_exists($class)) {
                return new $class(...$arguments);
            }
        }

        throw new InvalidArgumentException(
            sprintf('Input %s not found', $name)
        );
    }
}
