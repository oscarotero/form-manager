<?php
namespace FormManager\Inputs;

use FormManager\Traits\InputTrait;
use FormManager\Element;

abstract class Input extends Element
{
    use InputTrait;

    protected $name = 'input';

    /**
     * Magic method to create instances using the API Input::text().
     * 
     * @param string $name
     * @param array  $arguments
     * 
     * @return null|FormElement
     */
    public static function __callStatic($name, $arguments)
    {
        $class = __NAMESPACE__.'\\'.ucfirst($name);

        if (class_exists($class)) {
            return new $class();
        }
    }
}
