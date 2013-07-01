<?php
namespace FormManager;

abstract class Element {
	protected $attributes = array();

	public function __call ($name, $arguments) {
		$this->attr($name, (array_key_exists(0, $arguments) ? $arguments[0] : true));

		return $this;
	}

	public function __toString () {
		return $this->toHtml();
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

	static protected function attrHtml (array $attributes, array $mergedAttributes = null) {
		$html = '';

		if ($mergedAttributes !== null) {
			foreach ($mergedAttributes as $name => $value) {
				if (strpos($name, 'add-') === 0) {
					$name = substr($name, 4);

					if (!empty($attributes[$name])) {
						$attributes[$name] .= ' '.$value;
						continue;
					}
				}

				$attributes[$name] = $value;
			}
		}

		foreach ($attributes as $name => $value) {
			if (($value === null) || ($value === false)) {
				continue;
			}

			if ($value === true) {
				$html .= " $name";
			} else {
				$value = str_replace(array('&','\\"','"','<','>','&amp;amp;'), array('&amp;','&quot;','&quot;','&lt;','&gt;','&amp;'), $value);
				$html .= " $name=\"$value\"";
			}
		}

		return $html;
	}
}
