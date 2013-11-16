<?php
namespace FormManager;

class Element {
	protected $name;
	protected $close;
	protected $attributes = [];
	protected $data = [];
	protected $html;

	protected static function escape ($value) {
		return str_replace(array('&','\\"','"','<','>','&amp;amp;'), array('&amp;','&quot;','&quot;','&lt;','&gt;','&amp;'), $value);
	}

	public function __call ($name, $arguments) {
		$this->attr($name, (array_key_exists(0, $arguments) ? $arguments[0] : true));

		return $this;
	}

	public function __toString () {
		return $this->toHtml();
	}

	public function setElementName ($name, $close) {
		$this->name = $name;
		$this->close = $close;
	}

	public function html ($html = null) {
		if ($html === null) {
			return $this->html;
		}

		$this->html = $html;

		return $this;
	}

	public function attr ($name = null, $value = null) {
		if ($name === null) {
			return $this->attributes;
		}

		if (is_array($name)) {
			foreach ($name as $name => $value) {
				$this->attr($name, $value);
			}

			return $this;
		}

		if ($value === null) {
			return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
		}

		$this->attributes[$name] = $value;

		return $this;
	}

	public function removeAttr ($name) {
		unset($this->attributes[$name]);

		return $this;
	}

	public function data ($name = null, $value = null) {
		if ($name === null) {
			return $this->data;
		}

		if (is_array($name)) {
			foreach ($name as $name => $value) {
				$this->data[$name] = $value;
			}

			return $this;
		}

		if ($value === null) {
			return isset($this->data[$name]) ? $this->data[$name] : null;
		}

		$this->data[$name] = $value;

		return $this;
	}

	public function removeData ($name = null) {
		if ($name === null) {
			$this->data = [];
		} else {
			unset($this->data[$name]);
		}

		return $this;
	}

	public function addClass ($class) {
		$classes = $this->attr('class');

		if (!$classes) {
			return $this->attr('class', $class);
		}

		if (!is_array($classes)) {
			$classes = explode(' ', $classes);
		}

		if (!is_array($class)) {
			$class = explode(' ', $class);
		}

		return $this->attr('class', array_unique(array_merge($classes, $class)));
	}

	public function removeClass ($class) {
		$classes = $this->attr('class');

		if (!$classes) {
			return $this;
		}

		if (!is_array($classes)) {
			$classes = explode(' ', $classes);
		}

		if (!is_array($class)) {
			$class = explode(' ', $class);
		}

		return $this->attr('class', array_diff($classes, $class));
	}

	protected function attrToHtml () {
		$html = '';

		foreach ($this->attributes as $name => $value) {
			if (($value === null) || ($value === false)) {
				continue;
			}

			if ($value === true) {
				$html .= " $name";
			} else {
				if (is_array($value)) {
					$value = implode(' ', $value);
				}

				$html .= " $name=\"".static::escape($value)."\"";
			}
		}

		foreach ($this->data as $name => $value) {
			$html .= " data-$name=\"".static::escape($value)."\"";
		}

		return $html;
	}

	public function toHtml ($append = '') {
		$html = $this->openHtml();

		if ($this->close) {
			$html .= $this->html().$append.$this->closeHtml();
		}

		return $html;
	}

	public function openHtml () {
		return '<'.$this->name.$this->attrToHtml().'>';
	}

	public function closeHtml () {
		return ($this->close) ? '</'.$this->name.'>' : '';
	}
}
