<?php
namespace FormManager\Fieldsets;

use FormManager\Traits\CollectionTrait;
use FormManager\Traits\PropagateTrait;
use FormManager\Element;
use FormManager\Label;

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

	public function __get ($name) {
		if ($name === 'label') {
			return $this->label = new Label();
		}
	}

	public function label ($html = null) {
		if ($html === null) {
			return $this->label->html();
		}

		$this->label->html($html);

		return $this;
	}
}
