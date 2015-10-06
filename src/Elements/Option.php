<?php

namespace FormManager\Elements;

/**
 * Class to manage an option of a select.
 */
class Option extends Element
{
    protected $name = 'option';
    protected $close = true;

    /**
     * Creates a new option.
     *
     * @param string $value
     * @param mixed  $attributes
     */
    public static function create($value, $attributes = null)
    {
        $option = new static();
        $option->attr('value', $value);

        if (!is_array($attributes)) {
            return $option->html($attributes ? $attributes : $value);
        }

        foreach ($attributes as $n => $v) {
            $option->$n($v);
        }

        if (!$option->html()) {
            $option->html($value);
        }

        return $option;
    }

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        return $this->attr('selected', true);
    }

    /**
     * {@inheritdoc}
     */
    public function uncheck()
    {
        return $this->removeAttr('selected');
    }
}
