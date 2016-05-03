<?php

namespace FormManager\Traits;

use FormManager\Elements\Label;
use FormManager\Elements\Datalist;

/**
 * Class with methods used in input to generate the name attributes
 */
trait NameTrait
{
    protected $labels = [];
    protected $datalist;

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function setDatalist(Datalist $datalist)
    {
        $this->datalist = $datalist;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function addLabel(Label $label)
    {
        $this->labels[] = $label;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see InputInterface
     */
    public function removeLabel(Label $label)
    {
        $key = array_search($label, $this->labels, true);

        if ($key !== false) {
            unset($this->labels[$key]);
        }

        return $this;
    }
}
