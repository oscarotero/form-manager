<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Nodes\Node;
use Respect\Validation\Rules;
use Respect\Validation\Validatable;
use RuntimeException;

/**
 * Helper to build the validators
 */
abstract class ValidatorFactory
{
	public static function createValidator(Node $node, array $rules)
	{
		$required = array_search('required', $rules);

		if ($required !== false) {
			unset($rules[$required]);
		}

		$validator = [];

		foreach ($rules as $name) {
			if (!method_exists(self::class, $name) || $name === __METHOD__) {
				throw new RuntimeException(sprintf('Invalid validator name "%s"', $name));
			}

			$validator[] = self::$name($node);
		}

		$validator = new Rules\AllOf($validator);

		if ($required === false) {
			return new Rules\Optional($validator);
		}

		return new Rules\NotOptional($validator);
	}

	public static function url(): Validatable
	{
		return new Rules\Url();
	}

	public static function maxlength(Node $node): ?Validatable
	{
		if ($node->maxlength) {
    		return new Rules\Length(null, $node->maxlength);
    	}

    	return null;
	}

	public static function pattern(Node $node): ?Validatable
	{
		if ($node->pattern) {
    		$regex = sprintf('/^%s$/', str_replace('/', '\\/', $node->pattern));
    		return new Rules\Regex($regex);
    	}

    	return null;
	}
}