<?php
namespace FormManager;

abstract class Element {
	protected $name;
	protected $html;
	protected $close;
	protected $attributes = [];

	protected static function escape ($value) {
		return str_replace(array('&','\\"','"','<','>','&amp;amp;'), array('&amp;','&quot;','&quot;','&lt;','&gt;','&amp;'), $value);
	}

	public function __construct (array $attributes = null, $html = null) {
		if ($attributes !== null) {
			$this->attr($attributes);
		}

		if ($html !== null) {
			$this->html = $html;
		}
	}

	public function __call ($name, $arguments) {
		$this->attr($name, (array_key_exists(0, $arguments) ? $arguments[0] : true));

		return $this;
	}

	public function __toString () {
		return $this->toHtml();
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
				$html .= " $name=\"".static::escape($value)."\"";
			}
		}

		return $html;
	}

	public function toHtml () {
		$html = '<'.$this->name.$this->attrToHtml().'>';

		if ($this->close) {
			$html .= $this->html().'</'.$this->name.'>';
		}

		return $html;
	}
}
