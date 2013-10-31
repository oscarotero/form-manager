<?php
namespace FormManager;

use FormManager\Traits\InputIteratorTrait;
use FormManager\InputInterface;

class Form extends Element implements \Iterator, \ArrayAccess {
	use InputIteratorTrait;

	protected $name = 'form';
	protected $close = true;

	public function offsetSet ($offset, $value) {
		if (!($value instanceof InputInterface)) {
			throw new \InvalidArgumentException('Only elements implementing FormManager\\InputInterface must be added to forms');
		}

		if ($offset === null) {
			$offset = $value->attr('name');
		} else {
			$value->attr('name', $offset);
		}
var_dump($value->attr('name'));
		$this->inputs[$offset] = $value;
	}

	public function load (array $get = array(), array $post = array(), array $file = array()) {
		$data = ($this->attr('method') === 'post') ? $post : $get;

		foreach ($this->inputs as $name => $input) {
			$input->load((isset($data[$name]) ? $data[$name] : null), (isset($file[$name]) ? $file[$name] : null));
		}

		return $this;
	}

	public function val (array $value = null) {
		if ($value === null) {
			$value = array();

			foreach ($this->inputs as $name => $input) {
				$value[$name] = $input->val();
			}

			return $value;
		}

		foreach ($value as $name => $value) {
			if (isset($this->inputs[$name])) {
				$this->inputs[$name]->val($value);
			}
		}

		return $this;
	}

	public function isValid () {
		foreach ($this->inputs as $input) {
			if ($input->isValid() === false) {
				return false;
			}
		}

		return true;
	}

	public function html ($html = null) {
		if ($html === null) {
			$html = $this->html;

			foreach ($this->inputs as $input) {
				$html .= (string)$input;
			}

			return $html;
		}

		$this->html = $html;

		return $this;
	}
}
