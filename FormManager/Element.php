<?php
namespace FormManager;

abstract class Element {
	protected $name;
	protected $html;
	protected $attributes = array();

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

	protected function attrToHtml (array $extraAttributes = null) {
		$html = '';
		$attributes = $this->attributes;

		if ($extraAttributes !== null) {
			foreach ($extraAttributes as $name => $value) {
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

	public function toHtml (array $attributes = null) {
		$html = '<'.$this->name.$this->attrToHtml($attributes).'>';

		if ($this->html !== null) {
			$html .= $this->html.'</'.$this->name.'>';
		}

		return $html;
	}
}
