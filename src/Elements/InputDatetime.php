<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputDatetime extends Input implements DataElementInterface
{
    protected $format;

    /**
     * @see FormManager\DataElementInterface
     *
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->attr('value');
        }

        $this->attr('value', $this->transform($value));

        return $this;
    }

    /**
     * Set/get the datetime format used in this input
     * 
     * @param string $format
     * 
     * @return self|string
     */
    public function format($format = null)
    {
        if ($format === null) {
            return $format;
        }

        $this->format = $format;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function transform($value)
    {
        if ($value instanceof \Datetime) {
            return $value->format($this->format);
        }

        return $value;
    }
}
