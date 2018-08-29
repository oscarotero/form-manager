<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Inputs\Input;
use FormManager\Validators;
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

    public static function number(): Constraint
    {
        return new Constraints\Type('numeric');
    }

    public static function url(): Constraint
    {
        return new Constraints\Url();
    }

    public static function email(): Constraint
    {
        return new Constraints\Email();
    }

    public static function color(): Constraint
    {
        return new Constraints\Regex('/^#[a-f0-9]{6}$/');
    }

    public static function date(): Constraint
    {
        return new Constraints\Date();
    }

    public static function datetimeLocal(): Constraint
    {
        return new Constraints\DateTime(['format' => 'Y-m-d?H:i:s']);
    }

    public static function month(): Constraint
    {
        return new Constraints\DateTime(['format' => 'Y-m']);
    }

    public static function week(): Constraint
    {
        return new Constraints\Regex('/^[\d]{4}-W(0[1-9]|[1-4][0-9]|5[1-3])$/');
    }

    public static function time(Node $node): Constraint
    {
        return new Constraints\Datetime(['format' => $node->step ? 'H:i:s' : 'H:i']);
    }

    public static function file(): Constraint
    {
        return new Constraints\Callback([new Validators\UploadedFile(), '__invoke']);
    }

    public static function required(Node $node): Constraint
    {
        return new Constraints\NotBlank();
    }

    public static function length(Node $node): Constraint
    {
        $options = [
            'min' => $node->minlength ?: null,
            'max' => $node->maxlength ?: null
        ];
        
        return new Constraints\Length($options);
    }

    public static function max(Node $node): Constraint
    {
        return new Constraints\LessThanOrEqual($node->max);
    }

    public static function min(Node $node): Constraint
    {
        return new Constraints\GreaterThanOrEqual($node->min);
    }

    public static function step(Node $node): Constraint
    {
        $step = $node->step;

        return new Constraints\Callback(function ($value, $context) use ($step) {
            if ($value % $step) {
                $context->buildViolation('The value is not valid')
                    ->addViolation();
            }
        });
    }

    public static function pattern(Node $node): Constraint
    {
        $regex = sprintf('/^%s$/u', str_replace('/', '\\/', $node->pattern));

        return new Constraints\Regex($regex);
    }

    public static function accept(Node $node): Constraint
    {
        return new Constraints\Callback([new Validators\AcceptFile($node->accept), '__invoke']);
    }
}
