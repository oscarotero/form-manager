<?php
declare(strict_types=1);

namespace FormManager\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\LengthValidator;

/**
 * Optional length validator for Symfony Validator v6
 */
class OptionalLength6Validator extends LengthValidator
{
    /**
     * @{inheritdoc}
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if ('' === $value) {
            return;
        }

        parent::validate($value, $constraint);
    }
}
