<?php
namespace FormManager\Attributes;

class Multiple {
	public static function onAdd ($input, $value) {
		if (!is_bool($value)) {
			throw new \InvalidArgumentException('The multiple value must be a boolean');
		}

		if ($value && ($name = $input->attr('name')) && (substr($name, -2) !== '[]')) {
			$input->attr('name', $name.'[]');
		}

		return $value;
	}
}
