<?php
namespace FormManager;

use FormManager\Traits\CollectionTrait;
use FormManager\InputInterface;

use Iterator;
use ArrayAccess;

class Form extends Element implements Iterator, ArrayAccess, InputInterface {
	use CollectionTrait;

	protected $name = 'form';
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

	public function loadFromGlobal (array $get = array(), array $post = array(), array $file = array()) {
		if (func_num_args() === 0) {
			$get = $_GET;
			$post = $_POST;
			$file = $_FILES;
		}

		$value = ($this->attr('method') === 'post') ? $post : $get;

		return $this->load($value, $file);
	}

	public function id ($id = null) {
		if ($id === null) {
			return $this->attr('id');
		}

		return $this->attr('id', $id);
	}

	public function toHtml ($append = '') {
		return parent::toHtml($append.$this->childrenToHtml());
	}
}
