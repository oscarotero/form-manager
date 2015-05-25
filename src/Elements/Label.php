<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class Label extends Element
{
    protected $name = 'label';
    protected $close = true;
    protected $input;

    /**
     * Label constructor.
     *
     * @param null|DataElementInterface $input      The input associated to this label
     * @param null|array                $attributes Html attributes of this label
     * @param null|string               $html       String content of the label
     */
    public function __construct(DataElementInterface $input = null, array $attributes = null, $html = null)
    {
        if ($input !== null) {
            $this->setInput($input);
        }

        if ($attributes !== null) {
            $this->attr($attributes);
        }

        if ($html !== null) {
            $this->html = $html;
        }
    }

    /**
     * Sets a new input associated to this label.
     *
     * @param DataElementInterface $input The input instance
     */
    public function setInput(DataElementInterface $input)
    {
        //Ensure the id is defined
        if (!$input->attr('id')) {
            $input->attr('id', 'fm-input-'.(++static::$idCounter));
        }

        $this->input = $input;
    }

    /**
     * Converts the label to html code.
     *
     * @param string $prepend Optional string prepended to html content
     * @param string $append  Optional string appended to html content
     *
     * @return string
     */
    public function toHtml($prepend = '', $append = '')
    {
        //Do not print empty labels
        if (strlen($this->html.$prepend.$append) === 0) {
            return '';
        }

        if ($this->input) {
            $this->attr('for', $this->input->attr('id'));
        }

        return parent::toHtml($prepend, $append);
    }
}
