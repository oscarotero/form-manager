<?php
namespace FormManager\Fieldsets;

use FormManager\InputCollectionTrait;
use FormManager\Element;

abstract class Fieldset extends Element implements \Iterator, \ArrayAccess {
	use InputCollectionTrait;

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

	public function __construct (array $inputs = null) {
		if ($inputs) {
			$this->add($inputs);
		}
	}

	public function getKeys () {
		if (!$key = $this->getKey()) {
			return [];
		}

		$parent = $this;
		$keys = [$key];

		while (($parent = $parent->getParent()) && ($key = $parent->getKey())) {
			$keys[] = $key;
		}

		return $keys;
	}

	public function generateName () {
		if ($keys = $this->getKeys()) {
			$name = array_pop($keys);

			while ($keys) {
				$name .= '['.array_pop($keys).']';
			}

			$this->attr('name', $name);
		}
	}
}
