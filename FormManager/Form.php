<?php
namespace FormManager;

class Form extends Element implements \Iterator, \ArrayAccess, FormInterface {
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

	public function load (array $get = array(), array $post = array(), array $file = array()) {
		$data = ($this->attr('method') === 'post') ? $post : $get;

		foreach ($this->inputs as $name => $input) {
			$input->load((isset($data[$name]) ? $data[$name] : null), (isset($file[$name]) ? $file[$name] : null));
		}

		return $this;
	}

	public function getParent () {
		return null;
	}
}
