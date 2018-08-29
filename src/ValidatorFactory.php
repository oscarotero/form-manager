<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Inputs\Input;
use FormManager\Rules;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as v;
use RuntimeException;

/**
 * Helper to build the validators
 */
abstract class ValidatorFactory
{
    public static function createValidator(Input $input, array $rules): Validatable
    {
        $validators = [];
        $name = $input->getAttribute('name');

        foreach ($rules as $method) {
            if (!method_exists(self::class, $method) || $method === __METHOD__) {
                throw new RuntimeException(sprintf('Invalid validator name "%s"', $method));
            }

            $validator = self::$method($input);

            if ($validator) {
                if (!empty($name)) {
                    $validator->setName($name);
                }

                $validators[] = $validator;
            }
        }

        return v::allOf(...$validators);
    }

    public static function number(): Validatable
    {
        return v::numeric();
    }

    public static function url(): Validatable
    {
        return v::url();
    }

    public static function email(): Validatable
    {
        return v::email();
    }

    public static function color(): Validatable
    {
        return v::regex('/^#[a-f0-9]{6}$/');
    }

    public static function date(): Validatable
    {
        return v::date()->date('Y-m-d');
    }

    public static function datetimeLocal(): Validatable
    {
        return v::date()->date('Y-m-d\TH:i:s');
    }

    public static function month(): Validatable
    {
        return v::date()->date('Y-m');
    }

    public static function week(): Validatable
    {
        return v::date()->regex('/^\d+-W\d+$/');
    }

    public static function time(Node $node): Validatable
    {
        return v::date()->date($node->step ? 'H:i:s' : 'H:i');
    }

    public static function file(): Validatable
    {
        return new Rules\UploadedFile();
    }

    public static function required(Node $node): ?Validatable
    {
        if (!$node->required) {
            return null;
        }

        return $node->multiple ? v::notEmpty() : v::notOptional();
    }

    public static function maxlength(Node $node): ?Validatable
    {
        return $node->maxlength ? v::length(null, $node->maxlength) : null;
    }

    public static function minlength(Node $node): ?Validatable
    {
        return $node->minlength ? v::length($node->minlength, null) : null;
    }

    public static function max(Node $node): ?Validatable
    {
        return $node->max ? v::max($node->max) : null;
    }

    public static function min(Node $node): ?Validatable
    {
        return $node->min ? v::min($node->min) : null;
    }

    public static function step(Node $node): ?Validatable
    {
        return $node->step ? v::multiple($node->step) : null;
    }

    public static function pattern(Node $node): ?Validatable
    {
        if ($node->pattern) {
            $regex = sprintf('/^%s$/u', str_replace('/', '\\/', $node->pattern));
            return v::regex($regex);
        }

        return null;
    }

    public static function accept(Node $node): ?Validatable
    {
        return $node->accept ? new Rules\AcceptFile($node->accept) : null;
    }
}
