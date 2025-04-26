<?php
declare(strict_types = 1);

namespace FormManager;

use FormManager\Groups\Group;
use FormManager\Groups\GroupCollection;
use FormManager\Groups\MultipleGroupCollection;
use FormManager\Groups\RadioGroup;
use FormManager\Groups\SubmitGroup;
use FormManager\Inputs\Checkbox;
use FormManager\Inputs\Color;
use FormManager\Inputs\Date;
use FormManager\Inputs\DatetimeLocal;
use FormManager\Inputs\Email;
use FormManager\Inputs\File;
use FormManager\Inputs\Hidden;
use FormManager\Inputs\Month;
use FormManager\Inputs\Password;
use FormManager\Inputs\Radio;
use FormManager\Inputs\Range;
use FormManager\Inputs\Search;
use FormManager\Inputs\Select;
use FormManager\Inputs\Submit;
use FormManager\Inputs\Tel;
use FormManager\Inputs\Text;
use FormManager\Inputs\Textarea;
use FormManager\Inputs\Time;
use FormManager\Inputs\Url;
use FormManager\Inputs\Week;
use InvalidArgumentException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Factory class to create all nodes.
 *
 * @method static Form                           form(array $inputs = [], array $attributes = [])
 * @method static Group                   group(array $inputs = [])
 * @method static RadioGroup              radioGroup(array $radios = [])
 * @method static SubmitGroup             submitGroup(array $submits = [])
 * @method static GroupCollection         groupCollection(Group $group)
 * @method static MultipleGroupCollection multipleGroupCollection(array $groups)
 * @method static Checkbox                checkbox(?string $label = null, array $attributes = [])
 * @method static Color                   color(?string $label = null, array $attributes = [])
 * @method static Date                    date(?string $label = null, array $attributes = [])
 * @method static DatetimeLocal           datetimeLocal(?string $label = null, array $attributes = [])
 * @method static Email                   email(?string $label = null, array $attributes = [])
 * @method static File                    file(?string $label = null, array $attributes = [])
 * @method static Hidden                  hidden($value = null, array $attributes = [])
 * @method static Month                   month(?string $label = null, array $attributes = [])
 * @method static Number                  number(?string $label = null, array $attributes = [])
 * @method static Password                password(?string $label = null, array $attributes = [])
 * @method static Radio                   radio(?string $label = null, array $attributes = [])
 * @method static Range                   range(?string $label = null, array $attributes = [])
 * @method static Search                  search(?string $label = null, array $attributes = [])
 * @method static Select                  select(?string $label = null, array $options = [], array $attributes = [])
 * @method static Submit                  submit(?string $label = null, array $attributes = [])
 * @method static Tel                     tel(?string $label = null, array $attributes = [])
 * @method static Text                    text(?string $label = null, array $attributes = [])
 * @method static Textarea                textarea(?string $label = null, array $attributes = [])
 * @method static Time                    time(?string $label = null, array $attributes = [])
 * @method static Url                     url(?string $label = null, array $attributes = [])
 * @method static Week                    week(?string $label = null, array $attributes = [])
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
