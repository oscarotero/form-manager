<?php
namespace FormManager;


class Label extends Element
{
    protected $name = 'label';
    protected $close = true;
    protected $input;

    /**
     * Label constructor.
     *
     * @param null|InputInterface $input      The input associated to this label
     * @param null|array          $attributes Html attributes of this label
     * @param null|string         $html       String content of the label
     */
    public function __construct(InputInterface $input = null, array $attributes = null, $html = null)
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
     * @param InputInterface $input The input instance
     */
    public function setInput(InputInterface $input)
    {
        $this->input = $input;
        $this->input->id(); //ensure the id is defined
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
        if ($this->input) {
            $this->attr('for', $this->input->id());
        }

        return parent::toHtml($prepend, $append);
    }
}
