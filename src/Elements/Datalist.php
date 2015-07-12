<?php
namespace FormManager\Elements;

use FormManager\InputInterface;

class Datalist extends ElementContainer
{
    protected $name = 'datalist';
    protected $input;

    /**
     * Datalist constructor.
     *
     * @param InputInterface $input The input associated to this datalist
     */
    public function __construct(InputInterface $input)
    {
        $this->setInput($input);
    }

    public function offsetSet($offset, $value)
    {
        if ($value instanceof Option) {
            $value->attr('value', $offset);
        } else {
            $value = Option::create($offset, $value);
        }

        parent::offsetSet($offset, $value);
    }

    /**
     * Sets the input associated to this datalist.
     *
     * @param InputInterface $input The input instance
     */
    public function setInput(InputInterface $input)
    {
        //Ensure the datalist and input have ids defined
        $this->id();
        $input->id();

        //Assign the relation to each other
        $this->input = $input;
        $input->setDatalist($this);
    }

    /**
     * Set/Get the available options in this datalist.
     *
     * @param null|array $options null to getter, array to setter
     *
     * @return mixed
     */
    public function options(array $options = null)
    {
        if ($options === null) {
            return $this->children;
        }

        foreach ($options as $offset => $option) {
            $this->offsetSet($offset, $option);
        }

        return $this;
    }

    /**
     * Converts the datalist to html code.
     *
     * @param string $prepend Optional string prepended to html content
     * @param string $append  Optional string appended to html content
     *
     * @return string
     */
    public function toHtml($prepend = '', $append = '')
    {
        //Do not print empty datalists
        if (!$this->count() && strlen($prepend.$append) === 0) {
            return '';
        }

        return parent::toHtml($prepend, $append);
    }
}
