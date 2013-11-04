<?php
namespace FormManager\Fieldsets;

use FormManager\Traits\CollectionTrait;
use FormManager\Traits\PropagateTrait;
use FormManager\Element;

abstract class Fieldset extends Element implements \Iterator, \ArrayAccess {
	use CollectionTrait;
	use PropagateTrait;

	protected $name = 'fieldset';
	protected $close = true;

	public static function __callStatic ($name, $arguments) {
		$class = __NAMESPACE__.'\\'.ucfirst($name);

		if (class_exists($class)) {
			if (isset($arguments[0])) {
				return new $class($arguments[0]);
			}

			return new $class();
		}
	}
}
