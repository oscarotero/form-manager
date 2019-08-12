<?php

namespace FormManager;

use InvalidArgumentException;

/**
 * Factory class to create all nodes.
 * @method static \FormManager\Fields\Form form(string $label, array $attributes)
 * @method static \FormManager\Fields\Checkbox checkbox(string $label, array $attributes)
 * @method static \FormManager\Fields\Color color(string $label, array $attributes)
 * @method static \FormManager\Fields\Date date(string $label, array $attributes)
 * @method static \FormManager\Fields\DatetimeLocal datetimeLocal(string $label, array $attributes)
 * @method static \FormManager\Fields\Email email(string $label, array $attributes)
 * @method static \FormManager\Fields\File file(string $label, array $attributes)
 * @method static \FormManager\Fields\Hidden hidden(string $value, array $attributes)
 * @method static \FormManager\Fields\Month month(string $label, array $attributes)
 * @method static \FormManager\Fields\Number number(string $label, array $attributes)
 * @method static \FormManager\Fields\Password password(string $label, array $attributes)
 * @method static \FormManager\Fields\Radio radio(string $label, array $attributes)
 * @method static \FormManager\Fields\Range range(string $label, array $attributes)
 * @method static \FormManager\Fields\Search search(string $label, array $attributes)
 * @method static \FormManager\Fields\Select select(string $label, array $options, array $attributes)
 * @method static \FormManager\Fields\Submit submit(string $label, array $attributes)
 * @method static \FormManager\Fields\Tel tel(string $label, array $attributes)
 * @method static \FormManager\Fields\Text text(string $label, array $attributes)
 * @method static \FormManager\Fields\Textarea textarea(string $label, array $attributes)
 * @method static \FormManager\Fields\Time time(string $label, array $attributes)
 * @method static \FormManager\Fields\Url url(string $label, array $attributes)
 * @method static \FormManager\Fields\Week week(string $label, array $attributes)
 */
class Factory
{
    const NAMESPACES = [
        'FormManager\\Inputs\\',
        'FormManager\\Groups\\',
    ];

    /**
     * Factory to create input nodes
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
}
