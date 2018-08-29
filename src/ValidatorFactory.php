<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Inputs\Input;
use FormManager\Rules;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
use RuntimeException;

/**
 * Helper to build the validators
 */
abstract class ValidatorFactory
{
    public static function createConstraints(Input $input): array
    {
        $constraints = [];

        foreach ($input->getConstraints() as $method) {
            if (!method_exists(self::class, $method) || $method === __METHOD__) {
                throw new RuntimeException(sprintf('Invalid validator name "%s"', $method));
            }

            $constraint = self::$method($input);

            if ($constraint) {
                $constraints[$method] = $constraint;
            }
        }

        return $constraints;
    }

    public static function number(): Validatable
    {
        return v::numeric();
    }

    public static function url(): Validatable
    {
        return v::url();
    }

    public static function email(): Constraint
    {
        return new Constraints\Email();
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

    public static function length(Node $node): Constraint
    {
        $options = [
            'min' => $node->minlength ?: null,
            'max' => $node->maxlength ?: null
        ];
        
        return new Constraints\Length($options);
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

    public static function pattern(Node $node): Constraint
    {
        $regex = sprintf('/^%s$/u', str_replace('/', '\\/', $node->pattern));

        return new Constraints\Regex($regex);
    }

    public static function accept(Node $node): ?Validatable
    {
        return $node->accept ? new Rules\AcceptFile($node->accept) : null;
    }
}
