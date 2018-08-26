<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Node;
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
		$validator = [];

		foreach ($rules as $name) {
			if (!method_exists(self::class, $name) || $name === __METHOD__) {
				throw new RuntimeException(sprintf('Invalid validator name "%s"', $name));
			}

			$validator[] = self::$name($node);
		}

		return new Rules\AllOf(...$validator);
	}

	public static function number(): Validatable
	{
		return new Rules\Numeric();
	}

	public static function url(): Validatable
	{
		return new Rules\Url();
	}

	public static function email(): Validatable
	{
		return new Rules\Email();
	}

	public static function color(): Validatable
	{
		return new Rules\Regex('/^#[a-f0-9]{6}$/');
	}

	public static function date(): Validatable
	{
		return new Rules\Date('Y-m-d');
	}

	public static function datetimeLocal(): Validatable
	{
		return new Rules\Date('Y-m-d\TH:i:s');
	}

	public static function month(): Validatable
	{
		return new Rules\Date('Y-m');
	}

	public static function week(): Validatable
	{
		//Y-\WW ([0-9999] W[1-52])
		return new Rules\Regex('/^\d{1,4}-W([1-9]|[1-4][0-9]|5[0-2])$/');
	}

	public static function time(Node $node): Validatable
	{
		return $node->step ? new Rules\Date('H:i:s') : new Rules\Date('H:i');
	}

	public static function file(): Validatable
	{
		return new Rules\ArrayType();
	}

	public static function maxlength(Node $node): ?Validatable
	{
    	return $node->maxlength ? new Rules\Length(null, $node->maxlength) : null;
	}

	public static function minlength(Node $node): ?Validatable
	{
    	return $node->minlength ? new Rules\Length($node->minlength, null) : null;
	}

	public static function max(Node $node): ?Validatable
	{
    	return $node->max ? new Rules\Max($node->max) : null;
	}

	public static function min(Node $node): ?Validatable
	{
    	return $node->min ? new Rules\Min($node->min) : null;
	}

	public static function step(Node $node): ?Validatable
	{
    	return $node->step ? new Rules\Multiple($node->step) : null;
	}

	public static function pattern(Node $node): ?Validatable
	{
		if ($node->pattern) {
    		$regex = sprintf('/^%s$/u', str_replace('/', '\\/', $node->pattern));
    		return new Rules\Regex($regex);
    	}

    	return null;
	}
}