<?php
namespace FormManager;

use ReflectionClass;

/**
 * Basic form-manager factory
 */
class Factory implements FactoryInterface
{
    protected $cache = [];
    protected $namespaces = [
        'FormManager\\Inputs\\',
        'FormManager\\Containers\\',
    ];

    /**
     * {@inheritdoc}
     */
    public function get($name, array $arguments)
    {
        if (($class = $this->getClass($name)) !== false) {
            return empty($arguments) ? $class->newInstance() : $class->newInstanceArgs($arguments);
        }
    }

    /**
     * Search a class in the namespaces
     * 
     * @param string $name The class name
     * 
     * @return false|ReflectionClass
     */
    protected function getClass($name)
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        foreach ($this->namespaces as $namespace) {
            $class = $namespace.ucfirst($name);

            if (class_exists($class)) {
                return $this->cache[$name] = new ReflectionClass($class);
            }
        }

        return $this->cache[$name] = false;
    }
}
