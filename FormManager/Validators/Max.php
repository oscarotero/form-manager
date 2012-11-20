<?php
namespace FormManager\Validators;

class Max {
	protected function config ($config) {
		if (!is_float($config)) {
			throw new \InvalidArgumentException('The max value must be a float number');
		}

		return $config;
	}

	protected function validate ($value, $config) {
		return (empty($value) || ($value <= $config));
	}
}
