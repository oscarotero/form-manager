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
            if ($method instanceof Constraint) {
                $constraints[] = $method;
                continue;
            }

            if (!method_exists(self::class, $method)) {
                throw new RuntimeException(sprintf('Invalid validator name "%s"', $method));
            }

            $constraint = self::$method($input);

            if ($constraint) {
                $constraints[] = $constraint;
            }
        }

        return $constraints;
    }

    private static function options(
        Input $input,
        string $messageType,
        array $defaultOptions = [],
        $messageKey = 'message'
    ): array {
        $messages = $input->getErrorMessages();

        if (empty($messages[$messageType])) {
            return $defaultOptions;
        }

        return [$messageKey => $messages[$messageType]] + $defaultOptions;
    }

    public static function number(Input $input): Constraint
    {
        return new Constraints\Type(
            self::options($input, 'number', [
                'type' => 'numeric',
                'message' => 'This value is not a valid number.'
            ])
        );
    }

    public static function url(Input $input): Constraint
    {
        return new Constraints\Url(
            self::options($input, 'url')
        );
    }

    public static function email(Input $input): Constraint
    {
        return new Constraints\Email(
            self::options($input, 'email', ['mode' => 'html5'])
        );
    }

    public static function color(Input $input): Constraint
    {
        return new Constraints\Regex(
            self::options($input, 'color', [
                'pattern' => '/^#[a-f0-9]{6}$/',
                'message' => 'This value is not a valid color.'
            ])
        );
    }

    public static function date(Input $input): Constraint
    {
        return new Constraints\Date(
            self::options($input, 'date')
        );
    }

    public static function datetimeLocal(Input $input): Constraint
    {
        return new Constraints\DateTime(
            self::options($input, 'datetime-local', ['format' => 'Y-m-d?H:i:s'])
        );
    }

    public static function month(Input $input): Constraint
    {
        return new Constraints\DateTime(
            self::options($input, 'month', [
                'format' => 'Y-m',
                'message' => 'This value is not a valid month.'
            ])
        );
    }

    public static function week(Input $input): Constraint
    {
        return new Constraints\Regex(
            self::options($input, 'week', [
                'pattern' => '/^[\d]{4}-W(0[1-9]|[1-4][0-9]|5[1-3])$/',
                'message' => 'This value is not a valid week.'
            ])
        );
    }

    public static function time(Input $input): Constraint
    {
        if ($input->step) {
            return new Constraints\Time(
                self::options($input, 'time')
            );
        }

        return new Constraints\Datetime(
            self::options($input, 'time', [
                'format' => 'H:i',
                'message' => 'This value is not a valid time.'
            ])
        );
    }

    public static function file(Input $input): Constraint
    {
        return new Constraints\Callback(
            [new Validators\UploadedFile(self::options($input, 'file')), '__invoke']
        );
    }

    public static function required(Input $input): Constraint
    {
        return new Constraints\NotBlank(
            self::options($input, 'required')
        );
    }

    public static function length(Input $input): Constraint
    {
        $options = [];

        if ($input->minlength) {
            $options += self::options($input, 'minlength', ['min' => $input->minlength], 'minMessage');
        }

        if ($input->maxlength) {
            $options += self::options($input, 'maxlength', ['max' => $input->maxlength], 'maxMessage');
        }

        return new Constraints\Length($options);
    }

    public static function max(Input $input): Constraint
    {
        return new Constraints\LessThanOrEqual(
            self::options($input, 'max', ['value' => $input->max])
        );
    }

    public static function min(Input $input): Constraint
    {
        return new Constraints\GreaterThanOrEqual(
            self::options($input, 'min', ['value' => $input->min])
        );
    }

    public static function step(Input $input): Constraint
    {
        return new Constraints\Callback(
            [new Validators\Step(self::options($input, 'step', ['step' => $input->step])), '__invoke']
        );
    }

    public static function pattern(Input $input): Constraint
    {
        $pattern = sprintf('/^%s$/u', str_replace('/', '\\/', $input->pattern));

        return new Constraints\Regex(
            self::options($input, 'pattern', ['pattern' => $pattern])
        );
    }

    public static function accept(Input $input): Constraint
    {
        return new Constraints\Callback(
            [new Validators\AcceptFile(self::options($input, 'accept', ['accept' => $input->accept])), '__invoke']
        );
    }
}
