<?php
namespace FormManager\Attributes;

class Name {
	public static function onAdd ($input, $value) {
		if ($input->attr('multiple') && (substr($value, -2) !== '[]')) {
			$value .= '[]';
		}

		return $value;
	}
}
