<?php
declare(strict_types = 1);

namespace FormManager;

use InvalidArgumentException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FormManager;

/**
 * Factory class to create all nodes.
 *
 * @method static Form                           form(array $inputs = [], array $attributes = [])
 * @method static Groups\Group                   group(array $inputs = [])
 * @method static Groups\RadioGroup              radioGroup(array $radios = [])
 * @method static Groups\SubmitGroup             submitGroup(array $submits = [])
 * @method static Groups\GroupCollection         groupCollection(Groups\Group $group)
 * @method static Groups\MultipleGroupCollection multipleGroupCollection(array $groups)
 * @method static Inputs\Checkbox                checkbox(?string $label = null, array $attributes = [])
 * @method static Inputs\Color                   color(?string $label = null, array $attributes = [])
 * @method static Inputs\Date                    date(?string $label = null, array $attributes = [])
 * @method static Inputs\DatetimeLocal           datetimeLocal(?string $label = null, array $attributes = [])
 * @method static Inputs\Email                   email(?string $label = null, array $attributes = [])
 * @method static Inputs\File                    file(?string $label = null, array $attributes = [])
 * @method static Inputs\Hidden                  hidden($value = null, array $attributes = [])
 * @method static Inputs\Month                   month(?string $label = null, array $attributes = [])
 * @method static Inputs\Number                  number(?string $label = null, array $attributes = [])
 * @method static Inputs\Password                password(?string $label = null, array $attributes = [])
 * @method static Inputs\Radio                   radio(?string $label = null, array $attributes = [])
 * @method static Inputs\Range                   range(?string $label = null, array $attributes = [])
 * @method static Inputs\Search                  search(?string $label = null, array $attributes = [])
 * @method static Inputs\Select                  select(?string $label = null, array $options = [], array $attributes = [])
 * @method static Inputs\Submit                  submit(?string $label = null, array $attributes = [])
 * @method static Inputs\Tel                     tel(?string $label = null, array $attributes = [])
 * @method static Inputs\Text                    text(?string $label = null, array $attributes = [])
 * @method static Inputs\Textarea                textarea(?string $label = null, array $attributes = [])
 * @method static Inputs\Time                    time(?string $label = null, array $attributes = [])
 * @method static Inputs\Url                     url(?string $label = null, array $attributes = [])
 * @method static Inputs\Week                    week(?string $label = null, array $attributes = [])
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
