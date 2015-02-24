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
        $class = false;

        //Save the resolved classes in cache for performance
        if (isset(static::$cache[$name])) {
            $class = static::$cache[$name];
        } else {
            foreach (static::$namespaces as $namespace) {
                $c = $namespace.ucfirst($name);

                if (class_exists($c)) {
                    $class = $c;
                    break;
                }
            }

            static::$cache[$name] = $class;
        }

        if ($class) {
            return new $class(isset($arguments[0]) ? $arguments[0] : null);
        }
    }
}
