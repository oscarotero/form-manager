<?php
namespace FormManager;

/**
 * Factory class to create all elements.
 */
class Builder
{
    protected static $factories = [];
    protected $instanceFactories = [];

    /**
     * Add a factory class to the builder.
     *
     * @param FactoryInterface $factory
     */
    public static function addFactory(FactoryInterface $factory)
    {
        array_unshift(static::$factories, $factory);
    }

    /**
     * Constructor to use the Builder as a instance mode, instead static mode
     *
     * @param FactoryInterface|null $factory $factory
     */
    public function __construct(FactoryInterface $factory = null)
    {
        if ($factory !== null) {
            $this->add($factory);
        }
    }

    /**
     * Magic method to create instances using the API Builder::whatever().
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return null|DataElementInterface
     */
    public static function __callStatic($name, $arguments)
    {
        foreach (self::$factories as $factory) {
            if (($item = $factory->get($name, $arguments)) !== null) {
                return $item;
            }
        }
    }

    /**
     * Magic method to create instances using the API $builder->whatever().
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return null|DataElementInterface
     */
    public function __call($name, $arguments)
    {
        foreach ($this->instanceFactories as $factory) {
            if (($item = $factory->get($name, $arguments)) !== null) {
                return $item;
            }
        }
    }

    /**
     * Add a factory class to the builder.
     *
     * @param FactoryInterface $factory
     */
    public function add(FactoryInterface $factory)
    {
        array_unshift($this->instanceFactories, $factory);
    }
}

//Add the form-manager factory by default
Builder::addFactory(new Factory());
