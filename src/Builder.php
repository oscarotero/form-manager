<?php
namespace FormManager;

/**
 * Factory class to create all elements
 */
class Builder
{
    static protected $cache = [];
    static protected $namespaces = [
        'FormManager\\Inputs\\',
        'FormManager\\Containers\\'
    ];

    /**
     * Add more namespaces to the builder
     * 
     * @param string $namespace
     */
    public static function addNamespace($namespace)
    {
        static::$cache = [];

        array_unshift(static::$namespaces, $namespace);
    }

    /**
     * Magic method to create instances using the API Builder::whatever().
     * 
     * @param string $name
     * @param array  $arguments
     * 
     * @return null|FormElementInterface
     */
    public static function __callStatic($name, $arguments)
    {
        //Save the resolved classes in cache for performance
        if (isset(static::$cache[$name])) {
            $class = static::$cache[$name];

            if ($class) {
                return new $class(isset($arguments[0]) ? $arguments[0] : null);
            }

            return null;
        }

        foreach (static::$namespaces as $namespace) {
            $class = $namespace.ucfirst($name);
            
            if (class_exists($class)) {
                static::$cache[$name] = $class;

                return new $class(isset($arguments[0]) ? $arguments[0] : null);
            }
        }

        static::$cache[$name] = false;
    }
}
