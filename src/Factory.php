<?php
declare(strict_types=1);

namespace FormManager;

use InvalidArgumentException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Factory class to create all nodes.
 * 
 * @method static \FormManager\Form                           form(array $inputs, array $attributes)
 * @method static \FormManager\Groups\Group                   group(array $inputs)
 * @method static \FormManager\Groups\RadioGroup              radioGroup(array $radios)
 * @method static \FormManager\Groups\SubmitGroup             submitGroup(array $submits)
 * @method static \FormManager\Groups\GroupCollection         groupCollection(\FormManager\Groups\Group $group)
 * @method static \FormManager\Groups\MultipleGroupCollection multipleGroupCollection(array $groups)
 * @method static \FormManager\Inputs\Checkbox                checkbox(string $label, array $attributes)
 * @method static \FormManager\Inputs\Color                   color(string $label, array $attributes)
 * @method static \FormManager\Inputs\Date                    date(string $label, array $attributes)
 * @method static \FormManager\Inputs\DatetimeLocal           datetimeLocal(string $label, array $attributes)
 * @method static \FormManager\Inputs\Email                   email(string $label, array $attributes)
 * @method static \FormManager\Inputs\File                    file(string $label, array $attributes)
 * @method static \FormManager\Inputs\Hidden                  hidden(string $value, array $attributes)
 * @method static \FormManager\Inputs\Month                   month(string $label, array $attributes)
 * @method static \FormManager\Inputs\Number                  number(string $label, array $attributes)
 * @method static \FormManager\Inputs\Password                password(string $label, array $attributes)
 * @method static \FormManager\Inputs\Radio                   radio(string $label, array $attributes)
 * @method static \FormManager\Inputs\Range                   range(string $label, array $attributes)
 * @method static \FormManager\Inputs\Search                  search(string $label, array $attributes)
 * @method static \FormManager\Inputs\Select                  select(string $label, array $options, array $attributes)
 * @method static \FormManager\Inputs\Submit                  submit(string $label, array $attributes)
 * @method static \FormManager\Inputs\Tel                     tel(string $label, array $attributes)
 * @method static \FormManager\Inputs\Text                    text(string $label, array $attributes)
 * @method static \FormManager\Inputs\Textarea                textarea(string $label, array $attributes)
 * @method static \FormManager\Inputs\Time                    time(string $label, array $attributes)
 * @method static \FormManager\Inputs\Url                     url(string $label, array $attributes)
 * @method static \FormManager\Inputs\Week                    week(string $label, array $attributes)
 */
class Factory
{
    /** @var ValidatorInterface|null */
    private static $validator = null;

    public const NAMESPACES = [
        'FormManager\\Inputs\\',
        'FormManager\\Groups\\',
    ];

    /**
     * Factory to create input nodes
     *
     * @param mixed $arguments
     */
    public static function __callStatic(string $name, $arguments)
    {
        if ($name === 'form') {
            return new Form(...$arguments);
        }

        foreach (self::NAMESPACES as $namespace) {
            $class = $namespace.ucfirst($name);

            if (class_exists($class)) {
                return new $class(...$arguments);
            }
        }

        throw new InvalidArgumentException(
            sprintf('Input %s not found', $name)
        );
    }

    /**
     * @param array<string, string> $messages
     */
    public static function setErrorMessages(array $messages = []): void
    {
        ValidatorFactory::setMessages($messages);
    }

    public static function setValidator(ValidatorInterface $validator): void
    {
        self::$validator = $validator;
    }

    public static function getValidator(): ValidatorInterface
    {
        if (null === self::$validator) {
            return self::$validator = Validation::createValidator();
        }

        return self::$validator;
    }
}
